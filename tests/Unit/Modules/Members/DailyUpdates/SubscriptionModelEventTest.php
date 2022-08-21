<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Members\DailyUpdates;

use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\Blog\Models\BlogTag;
use Coeliac\Modules\Collection\Items\WhereToEat;
use Coeliac\Modules\Member\Events\DailyUpdateItemCreated;
use Coeliac\Modules\Member\Models\DailyUpdateType;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class SubscriptionModelEventTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Event::fake([DailyUpdateItemCreated::class]);
    }

    /** @test */
    public function itDispatchesTheDailyUpdateQueueEventWhenABlogIsAddedWithASubscibedTag()
    {
        $blog = $this->build(Blog::class)
            ->has($this->build(BlogTag::class), 'tags')
            ->create();

        Event::assertDispatched(
            DailyUpdateItemCreated::class,
            fn (DailyUpdateItemCreated $event) => $event->model()->is($blog) &&
                $event->dailyUpdateType()->id === DailyUpdateType::BLOG_TAGS
        );
    }

    /** @test */
    public function itDispatchesTheDailyUpdateQueueEventWhenAPlateToEatIsAdded()
    {
        $eatery = $this->create(WhereToEat::class);

        Event::assertDispatched(
            DailyUpdateItemCreated::class,
            fn (DailyUpdateItemCreated $event) => $event->model()->is($eatery) &&
                $event->dailyUpdateType()->id === DailyUpdateType::WTE_COUNTY
        );

        Event::assertDispatched(
            DailyUpdateItemCreated::class,
            fn (DailyUpdateItemCreated $event) => $event->model()->is($eatery) &&
                $event->dailyUpdateType()->id === DailyUpdateType::WTE_TOWN
        );
    }
}
