<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;
use Tests\Traits\CreatesWhereToEat;
use Coeliac\Modules\Blog\Models\Blog;
use Illuminate\Support\Facades\Event;
use Coeliac\Modules\Blog\Models\BlogTag;
use Coeliac\Modules\Member\Models\DailyUpdateType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\Member\Events\DailyUpdateItemCreated;

class DailyUpdateSubscriptionModelEventTest extends TestCase
{
    use CreatesWhereToEat;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Event::fake([DailyUpdateItemCreated::class]);
    }

    /** @test */
    public function itDispatchesTheDailyUpdateQueueEventWhenABlogIsAddedWithASubscibedTag()
    {
        $tag = factory(BlogTag::class)->create();
        $blog = factory(Blog::class)->create();

        $blog->tags()->attach($tag);

        Event::assertDispatched(
            DailyUpdateItemCreated::class,
            fn (DailyUpdateItemCreated $event) => $event->model()->is($blog) &&
                $event->dailyUpdateType()->id === DailyUpdateType::BLOG_TAGS
        );
    }

    /** @test */
    public function itDispatchesTheDailyUpdateQueueEventWhenAPlateToEatIsAdded()
    {
        $eatery = $this->createWhereToEat();

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
