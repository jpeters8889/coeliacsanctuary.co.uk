<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Members\DailyUpdates;

use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\Blog\Models\BlogTag;
use Coeliac\Modules\Collection\Items\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatTown;
use Coeliac\Modules\Member\Models\DailyUpdatesQueue;
use Coeliac\Modules\Member\Models\DailyUpdateType;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Notifications\DailyUpdate;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Tests\TestCase;

class SendCommandTest extends TestCase
{
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
        $user = $this->create(User::class);
        $tag = $this->create(BlogTag::class);

        DailyUpdateType::query()->find(DailyUpdateType::BLOG_TAGS)->subscribe($user, $tag);

        $this->assertEmpty(DailyUpdatesQueue::all());

        $blog = $this->create(Blog::class);
        $blog->tags()->attach($tag);

        $this->artisan('coeliac:send_daily_updates');

        Notification::assertSentTo($user, DailyUpdate::class);
    }

    /** @test */
    public function itOnlySendsTheBlogUpdate()
    {
        $user = $this->create(User::class);
        $tag = $this->create(BlogTag::class);

        DailyUpdateType::query()->find(DailyUpdateType::BLOG_TAGS)->subscribe($user, $tag);

        $blog = $this->create(Blog::class);
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

                return ! in_array(false, $assertions, true);
            }
        );
    }

    /** @test */
    public function itSendsTheWhereToEatUpdate()
    {
        $user = $this->create(User::class);

        DailyUpdateType::query()
            ->find(DailyUpdateType::WTE_COUNTY)
            ->subscribe($user, $county = WhereToEatCounty::query()->first());

        $eatery = $this->create(WhereToEat::class);

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

                return ! in_array(false, $assertions, true);
            }
        );
    }

    /** @test */
    public function itSendsTheBlogAndWhereToEatInOneNotification()
    {
        $user = $this->create(User::class);

        DailyUpdateType::query()
            ->find(DailyUpdateType::WTE_COUNTY)
            ->subscribe($user, $county = WhereToEatCounty::query()->first());

        $eatery = $this->create(WhereToEat::class);
        $tag = $this->create(BlogTag::class);

        DailyUpdateType::query()->find(DailyUpdateType::BLOG_TAGS)->subscribe($user, $tag);

        $blog = $this->create(Blog::class);
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

                return ! in_array(false, $assertions, true);
            }
        );
    }

    /** @test */
    public function itDoesntMentionBlogTagsIfNoneArePresent()
    {
        $user = $this->create(User::class);

        DailyUpdateType::query()
            ->find(DailyUpdateType::WTE_COUNTY)
            ->subscribe($user, $county = WhereToEatCounty::query()->first());

        $this->create(WhereToEat::class);

        $this->artisan('coeliac:send_daily_updates');

        Notification::assertSentTo(
            $user,
            DailyUpdate::class,
            function (DailyUpdate $notification) use ($user) {
                $compiledEmail = $notification->toMail($user)->render();

                return ! Str::contains($compiledEmail, 'Coeliac Sanctuary Blogs');
            }
        );
    }

    /** @test */
    public function itDoesntMentionWhereToEatIfNoneArePresent()
    {
        $user = $this->create(User::class);
        $tag = $this->create(BlogTag::class);

        DailyUpdateType::query()->find(DailyUpdateType::BLOG_TAGS)->subscribe($user, $tag);

        $blog = $this->create(Blog::class);
        $blog->tags()->attach($tag);

        $this->artisan('coeliac:send_daily_updates');

        Notification::assertSentTo(
            $user,
            DailyUpdate::class,
            function (DailyUpdate $notification) use ($user) {
                $compiledEmail = $notification->toMail($user)->render();

                return ! Str::contains($compiledEmail, 'Places To Eat');
            }
        );
    }

    /** @test */
    public function itHasMultipleBlogsListedIfMultipleAreAdded()
    {
        $user = $this->create(User::class);

        [$firstTag, $secondTag] = $this->build(BlogTag::class)
            ->state(new Sequence(
                ['tag' => 'First Tag'],
                ['tag' => 'Second Tag'],
            ))
            ->count(2)
            ->create();

        DailyUpdateType::query()->find(DailyUpdateType::BLOG_TAGS)->subscribe($user, $firstTag);
        DailyUpdateType::query()->find(DailyUpdateType::BLOG_TAGS)->subscribe($user, $secondTag);

        [$firstBlog, $secondBlog] = $this->build(Blog::class)
            ->state(new Sequence(
                ['title' => 'First Blog'],
                ['title' => 'Second Blog'],
            ))
            ->count(2)
            ->create();

        $firstBlog->tags()->attach($firstTag);
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

                return ! in_array(false, $assertions, true);
            }
        );
    }

    /** @test */
    public function itHasMultipleEateriesListedIfMultipleArePresent()
    {
        $user = $this->create(User::class);

        $firstTown = $this->create(
            WhereToEatTown::class,
            ['town' => 'First Town', 'county_id' => WhereToEatCounty::query()->first()->id]
        );

        $secondTown = $this->create(
            WhereToEatTown::class,
            ['town' => 'Second Town', 'county_id' => WhereToEatCounty::query()->first()->id]
        );

        DailyUpdateType::query()->find(DailyUpdateType::WTE_TOWN)->subscribe($user, $firstTown);
        DailyUpdateType::query()->find(DailyUpdateType::WTE_TOWN)->subscribe($user, $secondTown);

        $this->create(WhereToEat::class, ['town_id' => $firstTown->id, 'name' => 'First Place']);
        $this->create(WhereToEat::class, ['town_id' => $secondTown->id, 'name' => 'Second Place']);

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

                return ! in_array(false, $assertions, true);
            }
        );
    }

    /** @test */
    public function itCanSendToMultipleUsers()
    {
        [$firstUser, $secondUser] = $this->build(User::class)->count(2)->create();

        $tag = $this->create(BlogTag::class);

        DailyUpdateType::query()->find(DailyUpdateType::BLOG_TAGS)->subscribe($firstUser, $tag);
        DailyUpdateType::query()->find(DailyUpdateType::BLOG_TAGS)->subscribe($secondUser, $tag);

        $this->assertEmpty(DailyUpdatesQueue::all());

        $blog = $this->create(Blog::class);
        $blog->tags()->attach($tag);

        $this->artisan('coeliac:send_daily_updates');

        Notification::assertSentTo($firstUser, DailyUpdate::class);
        Notification::assertSentTo($secondUser, DailyUpdate::class);
    }

    /** @test */
    public function itDeletesTheQueudNotificationsAfterTheyAreSent()
    {
        $user = $this->create(User::class);
        $tag = $this->create(BlogTag::class);

        DailyUpdateType::query()->find(DailyUpdateType::BLOG_TAGS)->subscribe($user, $tag);

        $this->assertEmpty(DailyUpdatesQueue::all());

        $blog = $this->create(Blog::class);
        $blog->tags()->attach($tag);

        $this->assertNotEmpty(DailyUpdatesQueue::all());

        $this->artisan('coeliac:send_daily_updates');

        $this->assertEmpty(DailyUpdatesQueue::all());
    }

    /** @test */
    public function itIncludesAManagePreferencesLink()
    {
        $user = $this->create(User::class);
        $tag = $this->create(BlogTag::class);

        DailyUpdateType::query()->find(DailyUpdateType::BLOG_TAGS)->subscribe($user, $tag);

        $blog = $this->create(Blog::class);
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
