<?php

namespace Coeliac\Modules\Member\Listeners;

use Coeliac\Modules\Member\Events\DailyUpdateItemCreated;
use Coeliac\Modules\Member\Models\DailyUpdateType;
use Illuminate\Contracts\Queue\ShouldQueue;
use RuntimeException;

class FindEligibleDailyUpdatesToQueue implements ShouldQueue
{
    public $delay = 60;

    public function handle(DailyUpdateItemCreated $event)
    {
        switch ($event->dailyUpdateType()->id) {
            case DailyUpdateType::BLOG_TAGS:
                $this->handleBlogCreated($event);
                return;
            case DailyUpdateType::WTE_COUNTY:
            case DailyUpdateType::WTE_TOWN:
                $this->handleWhereToEatCreated($event);
                return;
        }

        throw new RuntimeException('Unknown update type');
    }

    protected function handleBlogCreated(DailyUpdateItemCreated $event)
    {
        // find all the tags
        // foreach one see if anyone is subscribed
        // foreach subscriber, if the blog isnt in the queue for the user, add it
    }

    protected function handleWhereToEatCreated(DailyUpdateItemCreated $event)
    {
        //
    }
}
