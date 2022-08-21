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
use Tests\TestCase;

class ItemCreatedListenerTest extends TestCase
{
    /** @test */
    public function itQueuesAnUpdateForASubscribedBlogTag()
    {
        $user = $this->create(User::class);
        $tag = $this->create(BlogTag::class);

        DailyUpdateType::query()->find(DailyUpdateType::BLOG_TAGS)->subscribe($user, $tag);

        $this->assertEmpty(DailyUpdatesQueue::all());

        $blog = $this->create(Blog::class);
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
        $user = $this->create(User::class);
        [$firstTag, $secondTag] = $this->build(BlogTag::class)->count(2)->create();

        /** @var DailyUpdateType $dailyUpdateType */
        $dailyUpdateType = DailyUpdateType::query()->find(DailyUpdateType::BLOG_TAGS);

        $dailyUpdateType->subscribe($user, $firstTag);
        $dailyUpdateType->subscribe($user, $secondTag);

        $this->assertEmpty(DailyUpdatesQueue::all());

        $blog = $this->create(Blog::class);
        $blog->tags()->attach([$firstTag->id, $secondTag->id]);

        $this->assertCount(2, $blog->fresh()->tags);

        $this->assertNotEmpty(DailyUpdatesQueue::all());
        $this->assertCount(1, DailyUpdatesQueue::all());
    }

    /** @test */
    public function itWillQueueUpdatesForTwoDifferentBlogs()
    {
        $user = $this->create(User::class);
        $tag = $this->create(BlogTag::class);

        DailyUpdateType::query()->find(DailyUpdateType::BLOG_TAGS)->subscribe($user, $tag);

        $this->assertEmpty(DailyUpdatesQueue::all());

        [$firstBlog, $secondBlog] = $this->build(Blog::class)->count(2)->create();

        $firstBlog->tags()->attach($tag);
        $secondBlog->tags()->attach($tag);

        $this->assertNotEmpty(DailyUpdatesQueue::all());
        $this->assertCount(2, DailyUpdatesQueue::all());
    }

    /** @test */
    public function itWillQueueAnUpdateForACounty()
    {
        $user = $this->create(User::class);

        DailyUpdateType::query()
            ->find(DailyUpdateType::WTE_COUNTY)
            ->subscribe($user, WhereToEatCounty::query()->first());

        $this->assertEmpty(DailyUpdatesQueue::all());

        $eatery = $this->create(WhereToEat::class);

        $this->assertNotEmpty(DailyUpdatesQueue::all());

        /** @var DailyUpdatesQueue $queuedDailyUpdate */
        $queuedDailyUpdate = DailyUpdatesQueue::query()->first();

        $this->assertTrue($queuedDailyUpdate->newItem->is($eatery));
    }

    /** @test */
    public function itWillQueueAnUpdateForATown()
    {
        $user = $this->create(User::class);

        DailyUpdateType::query()
            ->find(DailyUpdateType::WTE_TOWN)
            ->subscribe($user, WhereToEatTown::query()->first());

        $this->assertEmpty(DailyUpdatesQueue::all());

        $eatery = $this->create(WhereToEat::class);

        $this->assertNotEmpty(DailyUpdatesQueue::all());

        /** @var DailyUpdatesQueue $queuedDailyUpdate */
        $queuedDailyUpdate = DailyUpdatesQueue::query()->first();

        $this->assertTrue($queuedDailyUpdate->newItem->is($eatery));
    }

    /** @test */
    public function ifAUserIsSubscribedToACountyAndTownAndAPlaceIsAddedThatMatchesBothItOnlyQueuesOneUpdate()
    {
        $user = $this->create(User::class);

        DailyUpdateType::query()
            ->find(DailyUpdateType::WTE_COUNTY)
            ->subscribe($user, WhereToEatCounty::query()->first());

        DailyUpdateType::query()
            ->find(DailyUpdateType::WTE_TOWN)
            ->subscribe($user, WhereToEatTown::query()->first());

        $this->assertEmpty(DailyUpdatesQueue::all());

        $eatery = $this->create(WhereToEat::class);

        $this->assertNotEmpty(DailyUpdatesQueue::all());
        $this->assertCount(1, DailyUpdatesQueue::all());

        /** @var DailyUpdatesQueue $queuedDailyUpdate */
        $queuedDailyUpdate = DailyUpdatesQueue::query()->first();

        $this->assertTrue($queuedDailyUpdate->newItem->is($eatery));
    }
}
