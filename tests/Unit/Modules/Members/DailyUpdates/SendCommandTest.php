<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Members\DailyUpdates;

use Tests\TestCase;
use Illuminate\Support\Str;
use Tests\Traits\CreatesWhereToEat;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Blog\Models\BlogTag;
use Illuminate\Support\Facades\Notification;
use Coeliac\Modules\Member\Models\DailyUpdateType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\Member\Models\DailyUpdatesQueue;
use Coeliac\Modules\Member\Notifications\DailyUpdate;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatTown;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCountry;

class SendCommandTest extends TestCase
{
    use CreatesWhereToEat;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Notification::fake();
    }

    /** @test */
    public function itDoesntSendAnythingIfTheresNothingToSend()
    {
        $this->artisan('coeliac:send_daily_updates');

        Notification::assertNothingSent();
    }

    /** @test */
    public function itSendsANotificationWhenTheUserHasOneQueud()
    {
        $user = factory(User::class)->create();
        $tag = factory(BlogTag::class)->create();

        DailyUpdateType::query()->find(DailyUpdateType::BLOG_TAGS)->subscribe($user, $tag);

        $this->assertEmpty(DailyUpdatesQueue::all());

        $blog = factory(Blog::class)->create();
        $blog->tags()->attach($tag);

        $this->artisan('coeliac:send_daily_updates');

        Notification::assertSentTo($user, DailyUpdate::class);
    }

    /** @test */
    public function itOnlySendsTheBlogUpdate()
    {
        $user = factory(User::class)->create();
        $tag = factory(BlogTag::class)->create();

        DailyUpdateType::query()->find(DailyUpdateType::BLOG_TAGS)->subscribe($user, $tag);

        $blog = factory(Blog::class)->create();
        $blog->tags()->attach($tag);

        $this->artisan('coeliac:send_daily_updates');

        Notification::assertSentTo(
            $user,
            DailyUpdate::class,
            function (DailyUpdate $notification) use ($user, $blog, $tag) {
                $compiledEmail = $notification->toMail($user)->render();

                $assertions = [
                    Str::contains($compiledEmail, 'Coeliac Sanctuary Blogs'),
                    Str::contains($compiledEmail, $tag->tag),
                    Str::contains($compiledEmail, $blog->slug),
                    Str::contains($compiledEmail, $blog->title),
                    Str::contains($compiledEmail, $blog->meta_description),
                ];

                return !in_array(false, $assertions, true);
            }
        );
    }

    /** @test */
    public function itSendsTheWhereToEatUpdate()
    {
        $user = factory(User::class)->create();
        $country = factory(WhereToEatCountry::class)->create();
        $county = factory(WhereToEatCounty::class)->create(['country_id' => $country->id]);
        $town = factory(WhereToEatTown::class)->create(['county_id' => $county->id]);

        DailyUpdateType::query()->find(DailyUpdateType::WTE_COUNTY)->subscribe($user, $county);

        $eatery = $this->createWhereToEat(['county_id' => $county->id, 'town_id' => $town->id]);

        $this->artisan('coeliac:send_daily_updates');

        Notification::assertSentTo(
            $user,
            DailyUpdate::class,
            function (DailyUpdate $notification) use ($user, $eatery, $county) {
                $compiledEmail = $notification->toMail($user)->render();

                $assertions = [
                    Str::contains($compiledEmail, 'Places To Eat'),
                    Str::contains($compiledEmail, $county->county),
                    Str::contains($compiledEmail, $county->slug),
                    Str::contains($compiledEmail, $eatery->name),
                    Str::contains($compiledEmail, $eatery->full_location),
                    Str::contains($compiledEmail, $eatery->info),
                    Str::contains($compiledEmail, str_replace('<br />', ', ', $eatery->address)),
                ];

                return !in_array(false, $assertions, true);
            }
        );
    }

    /** @test */
    public function itSendsTheBlogAndWhereToEatInOneNotification()
    {
        $user = factory(User::class)->create();
        $country = factory(WhereToEatCountry::class)->create();
        $county = factory(WhereToEatCounty::class)->create(['country_id' => $country->id]);
        $town = factory(WhereToEatTown::class)->create(['county_id' => $county->id]);

        DailyUpdateType::query()->find(DailyUpdateType::WTE_COUNTY)->subscribe($user, $county);

        $eatery = $this->createWhereToEat(['county_id' => $county->id, 'town_id' => $town->id]);

        $tag = factory(BlogTag::class)->create();

        DailyUpdateType::query()->find(DailyUpdateType::BLOG_TAGS)->subscribe($user, $tag);

        $blog = factory(Blog::class)->create();
        $blog->tags()->attach($tag);

        $this->artisan('coeliac:send_daily_updates');

        Notification::assertSentTo(
            $user,
            DailyUpdate::class,
            function (DailyUpdate $notification) use ($user, $blog, $tag, $eatery, $county) {
                $compiledEmail = $notification->toMail($user)->render();

                $assertions = [
                    Str::contains($compiledEmail, 'Coeliac Sanctuary Blogs'),
                    Str::contains($compiledEmail, $tag->tag),
                    Str::contains($compiledEmail, $blog->slug),
                    Str::contains($compiledEmail, $blog->title),
                    Str::contains($compiledEmail, $blog->meta_description),
                    Str::contains($compiledEmail, 'Places To Eat'),
                    Str::contains($compiledEmail, $county->county),
                    Str::contains($compiledEmail, $county->slug),
                    Str::contains($compiledEmail, $eatery->name),
                    Str::contains($compiledEmail, $eatery->full_location),
                    Str::contains($compiledEmail, $eatery->info),
                    Str::contains($compiledEmail, str_replace('<br />', ', ', $eatery->address)),
                ];

                return !in_array(false, $assertions, true);
            }
        );
    }

    /** @test */
    public function itDoesntMentionBlogTagsIfNoneArePresent()
    {
        $user = factory(User::class)->create();
        $country = factory(WhereToEatCountry::class)->create();
        $county = factory(WhereToEatCounty::class)->create(['country_id' => $country->id]);
        $town = factory(WhereToEatTown::class)->create(['county_id' => $county->id]);

        DailyUpdateType::query()->find(DailyUpdateType::WTE_COUNTY)->subscribe($user, $county);

        $eatery = $this->createWhereToEat(['county_id' => $county->id, 'town_id' => $town->id]);

        $this->artisan('coeliac:send_daily_updates');

        Notification::assertSentTo(
            $user,
            DailyUpdate::class,
            function (DailyUpdate $notification) use ($user) {
                $compiledEmail = $notification->toMail($user)->render();

                return !Str::contains($compiledEmail, 'Coeliac Sanctuary Blogs');
            }
        );
    }

    /** @test */
    public function itDoesntMentionWhereToEatIfNoneArePresent()
    {
        $user = factory(User::class)->create();
        $tag = factory(BlogTag::class)->create();

        DailyUpdateType::query()->find(DailyUpdateType::BLOG_TAGS)->subscribe($user, $tag);

        $blog = factory(Blog::class)->create();
        $blog->tags()->attach($tag);

        $this->artisan('coeliac:send_daily_updates');

        Notification::assertSentTo(
            $user,
            DailyUpdate::class,
            function (DailyUpdate $notification) use ($user) {
                $compiledEmail = $notification->toMail($user)->render();

                return !Str::contains($compiledEmail, 'Places To Eat');
            }
        );
    }

    /** @test */
    public function itHasMultipleBlogsListedIfMultipleAreAdded()
    {
        $user = factory(User::class)->create();
        $firstTag = factory(BlogTag::class)->create(['tag' => 'First Tag']);
        $secondTag = factory(BlogTag::class)->create(['tag' => 'Second Tag']);

        DailyUpdateType::query()->find(DailyUpdateType::BLOG_TAGS)->subscribe($user, $firstTag);
        DailyUpdateType::query()->find(DailyUpdateType::BLOG_TAGS)->subscribe($user, $secondTag);

        $firstBlog = factory(Blog::class)->create(['title' => 'First Blog']);
        $firstBlog->tags()->attach($firstTag);

        $secondBlog = factory(Blog::class)->create(['title' => 'Second Blog']);
        $secondBlog->tags()->attach($secondTag);

        $this->artisan('coeliac:send_daily_updates');

        Notification::assertSentTo(
            $user,
            DailyUpdate::class,
            function (DailyUpdate $notification) use ($user) {
                $compiledEmail = $notification->toMail($user)->render();

                $assertions = [
                    Str::contains($compiledEmail, 'First Tag, Second Tag'),
                    Str::contains($compiledEmail, 'First Blog'),
                    Str::contains($compiledEmail, 'Second Blog'),
                ];

                return !in_array(false, $assertions, true);
            }
        );
    }

    /** @test */
    public function itHasMultipleEateriesListedIfMultipleArePresent()
    {
        $user = factory(User::class)->create();
        $country = factory(WhereToEatCountry::class)->create();
        $county = factory(WhereToEatCounty::class)->create(['country_id' => $country->id]);
        $firstTown = factory(WhereToEatTown::class)->create(['town' => 'First Town', 'county_id' => $county->id]);
        $secondTown = factory(WhereToEatTown::class)->create(['town' => 'Second Town', 'county_id' => $county->id]);

        DailyUpdateType::query()->find(DailyUpdateType::WTE_TOWN)->subscribe($user, $firstTown);
        DailyUpdateType::query()->find(DailyUpdateType::WTE_TOWN)->subscribe($user, $secondTown);

        $this->createWhereToEat(['county_id' => $county->id, 'town_id' => $firstTown->id, 'name' => 'First Place']);
        $this->createWhereToEat(['county_id' => $county->id, 'town_id' => $secondTown->id, 'name' => 'Second Place']);

        $this->artisan('coeliac:send_daily_updates');

        Notification::assertSentTo(
            $user,
            DailyUpdate::class,
            function (DailyUpdate $notification) use ($user) {
                $compiledEmail = $notification->toMail($user)->render();

                $assertions = [
                    Str::contains($compiledEmail, 'First Town, Second Town'),
                    Str::contains($compiledEmail, 'First Place'),
                    Str::contains($compiledEmail, 'Second Place'),
                ];

                return !in_array(false, $assertions, true);
            }
        );
    }

    /** @test */
    public function itCanSendToMultipleUsers()
    {
        $firstUser = factory(User::class)->create();
        $secondUser = factory(User::class)->create();

        $tag = factory(BlogTag::class)->create();

        DailyUpdateType::query()->find(DailyUpdateType::BLOG_TAGS)->subscribe($firstUser, $tag);
        DailyUpdateType::query()->find(DailyUpdateType::BLOG_TAGS)->subscribe($secondUser, $tag);

        $this->assertEmpty(DailyUpdatesQueue::all());

        $blog = factory(Blog::class)->create();
        $blog->tags()->attach($tag);

        $this->artisan('coeliac:send_daily_updates');

        Notification::assertSentTo($firstUser, DailyUpdate::class);
        Notification::assertSentTo($secondUser, DailyUpdate::class);
    }

    /** @test */
    public function itDeletesTheQueudNotificationsAfterTheyAreSent()
    {
        $user = factory(User::class)->create();
        $tag = factory(BlogTag::class)->create();

        DailyUpdateType::query()->find(DailyUpdateType::BLOG_TAGS)->subscribe($user, $tag);

        $this->assertEmpty(DailyUpdatesQueue::all());

        $blog = factory(Blog::class)->create();
        $blog->tags()->attach($tag);

        $this->assertNotEmpty(DailyUpdatesQueue::all());

        $this->artisan('coeliac:send_daily_updates');

        $this->assertEmpty(DailyUpdatesQueue::all());
    }

    /** @test */
    public function itIncludesAManagePreferencesLink()
    {
        $user = factory(User::class)->create();
        $tag = factory(BlogTag::class)->create();

        DailyUpdateType::query()->find(DailyUpdateType::BLOG_TAGS)->subscribe($user, $tag);

        $blog = factory(Blog::class)->create();
        $blog->tags()->attach($tag);

        $this->artisan('coeliac:send_daily_updates');

        Notification::assertSentTo(
            $user,
            DailyUpdate::class,
            function (DailyUpdate $notification) use ($user) {
                return Str::contains($notification->toMail($user)->render(), 'change your preferences or unsubscribe');
            }
        );
    }
}
