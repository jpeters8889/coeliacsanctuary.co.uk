<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Members\DailyUpdates;

use Tests\TestCase;
use Tests\Traits\CreatesWhereToEat;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Blog\Models\BlogTag;
use Coeliac\Modules\Member\Models\DailyUpdateType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\Member\Models\DailyUpdatesQueue;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatTown;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCountry;

class ItemCreatedListenerTest extends TestCase
{
    use CreatesWhereToEat;
    use RefreshDatabase;

    /** @test */
    public function itQueuesAnUpdateForASubscribedBlogTag()
    {
        $user = factory(User::class)->create();
        $tag = factory(BlogTag::class)->create();

        DailyUpdateType::query()->find(DailyUpdateType::BLOG_TAGS)->subscribe($user, $tag);

        $this->assertEmpty(DailyUpdatesQueue::all());

        $blog = factory(Blog::class)->create();
        $blog->tags()->attach($tag);

        $this->assertNotEmpty(DailyUpdatesQueue::all());

        /** @var DailyUpdatesQueue $queuedDailyUpdate */
        $queuedDailyUpdate = DailyUpdatesQueue::query()->first();

        $this->assertTrue($queuedDailyUpdate->newItem->is($blog));
        $this->assertTrue($queuedDailyUpdate->subscription->user->is($user));
        $this->assertTrue($queuedDailyUpdate->subscription->updatable->is($tag));
    }

    /** @test */
    public function itDoesntQueueTwoUpdatesForTheSameBlogWhenSubscribedToTwoTags()
    {
        $user = factory(User::class)->create();
        $firstTag = factory(BlogTag::class)->create();
        $secondTag = factory(BlogTag::class)->create();

        /** @var DailyUpdateType $dailyUpdateType */
        $dailyUpdateType = DailyUpdateType::query()->find(DailyUpdateType::BLOG_TAGS);

        $dailyUpdateType->subscribe($user, $firstTag);
        $dailyUpdateType->subscribe($user, $secondTag);

        $this->assertEmpty(DailyUpdatesQueue::all());

        $blog = factory(Blog::class)->create();
        $blog->tags()->attach([$firstTag->id, $secondTag->id]);

        $this->assertCount(2, $blog->fresh()->tags);

        $this->assertNotEmpty(DailyUpdatesQueue::all());
        $this->assertCount(1, DailyUpdatesQueue::all());
    }

    /** @test */
    public function itWillQueueUpdatesForTwoDifferentBlogs()
    {
        $user = factory(User::class)->create();
        $tag = factory(BlogTag::class)->create();

        DailyUpdateType::query()->find(DailyUpdateType::BLOG_TAGS)->subscribe($user, $tag);

        $this->assertEmpty(DailyUpdatesQueue::all());

        $firstBlog = factory(Blog::class)->create();
        $firstBlog->tags()->attach($tag);

        $secondBlog = factory(Blog::class)->create();
        $secondBlog->tags()->attach($tag);

        $this->assertNotEmpty(DailyUpdatesQueue::all());
        $this->assertCount(2, DailyUpdatesQueue::all());
    }

    /** @test */
    public function itWillQueueAnUpdateForACounty()
    {
        $user = factory(User::class)->create();

        $country = factory(WhereToEatCountry::class)->create();
        $county = factory(WhereToEatCounty::class)->create(['country_id' => $country->id]);
        $town = factory(WhereToEatTown::class)->create(['county_id' => $county->id]);

        DailyUpdateType::query()->find(DailyUpdateType::WTE_COUNTY)->subscribe($user, $county);

        $this->assertEmpty(DailyUpdatesQueue::all());

        $eatery = $this->createWhereToEat([
            'county_id' => $county->id,
            'town_id' => $town->id,
        ]);

        $this->assertNotEmpty(DailyUpdatesQueue::all());

        /** @var DailyUpdatesQueue $queuedDailyUpdate */
        $queuedDailyUpdate = DailyUpdatesQueue::query()->first();

        $this->assertTrue($queuedDailyUpdate->newItem->is($eatery));
    }

    /** @test */
    public function itWillQueueAnUpdateForATown()
    {
        $user = factory(User::class)->create();

        $country = factory(WhereToEatCountry::class)->create();
        $county = factory(WhereToEatCounty::class)->create(['country_id' => $country->id]);
        $town = factory(WhereToEatTown::class)->create(['county_id' => $county->id]);

        DailyUpdateType::query()->find(DailyUpdateType::WTE_TOWN)->subscribe($user, $town);

        $this->assertEmpty(DailyUpdatesQueue::all());

        $eatery = $this->createWhereToEat([
            'county_id' => $county->id,
            'town_id' => $town->id,
        ]);

        $this->assertNotEmpty(DailyUpdatesQueue::all());

        /** @var DailyUpdatesQueue $queuedDailyUpdate */
        $queuedDailyUpdate = DailyUpdatesQueue::query()->first();

        $this->assertTrue($queuedDailyUpdate->newItem->is($eatery));
    }

    /** @test */
    public function ifAUserIsSubscribedToACountyAndTownAndAPlaceIsAddedThatMatchesBothItOnlyQueuesOneUpdate()
    {
        $user = factory(User::class)->create();

        $country = factory(WhereToEatCountry::class)->create();
        $county = factory(WhereToEatCounty::class)->create(['country_id' => $country->id]);
        $town = factory(WhereToEatTown::class)->create(['county_id' => $county->id]);

        DailyUpdateType::query()->find(DailyUpdateType::WTE_COUNTY)->subscribe($user, $county);
        DailyUpdateType::query()->find(DailyUpdateType::WTE_TOWN)->subscribe($user, $town);

        $this->assertEmpty(DailyUpdatesQueue::all());

        $eatery = $this->createWhereToEat([
            'county_id' => $county->id,
            'town_id' => $town->id,
        ]);

        $this->assertNotEmpty(DailyUpdatesQueue::all());
        $this->assertCount(1, DailyUpdatesQueue::all());

        /** @var DailyUpdatesQueue $queuedDailyUpdate */
        $queuedDailyUpdate = DailyUpdatesQueue::query()->first();

        $this->assertTrue($queuedDailyUpdate->newItem->is($eatery));
    }
}
