<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Listeners;

use RuntimeException;
use Coeliac\Modules\Blog\Models\BlogTag;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Coeliac\Modules\Member\Contracts\Updatable;
use Coeliac\Modules\Member\Models\DailyUpdateType;
use Coeliac\Modules\Member\Models\DailyUpdatesQueue;
use Coeliac\Modules\Member\Events\DailyUpdateItemCreated;
use Coeliac\Modules\Member\Models\UserDailyUpdateSubscription;

class FindEligibleDailyUpdatesToQueue implements ShouldQueue
{
    public $delay = 60;

    protected ?DailyUpdateItemCreated $event = null;

    public function handle(DailyUpdateItemCreated $event)
    {
        $this->event = $event;

        switch ($event->dailyUpdateType()->id) {
            case DailyUpdateType::BLOG_TAGS:
                $this->handleBlogCreated();

                return;
            case DailyUpdateType::WTE_COUNTY:
            case DailyUpdateType::WTE_TOWN:
                $this->handleWhereToEatCreated();

                return;
        }

        throw new RuntimeException('Unknown update type');
    }

    protected function handleBlogCreated(): void
    {
        $tags = $this->event->model()->tags()->get();

        if (!$tags) {
            return;
        }

        $tags->each(fn (BlogTag $tag) => $this->processUpdatable($tag));
    }

    protected function handleWhereToEatCreated(): void
    {
        $this->processUpdatable($this->event->model()->county());
        $this->processUpdatable($this->event->model()->town());
    }

    protected function processUpdatable(Updatable $updatable): void
    {
        $subscribers = $this->getUpdateSubscribers($updatable);

        if ($subscribers->isEmpty()) {
            return;
        }

        $subscribers->each(fn (UserDailyUpdateSubscription $subscription) => $this->queueUpdateForUser($subscription));
    }

    protected function getUpdateSubscribers(Updatable $updatable): Collection
    {
        return $this->event
            ->dailyUpdateType()
            ->subscriptions()
            ->where('updatable_type', get_class($updatable))
            ->where('updatable_id', $updatable->id)
            ->get();
    }

    protected function queueUpdateForUser(UserDailyUpdateSubscription $subscription): void
    {
        DailyUpdatesQueue::queueItemForUser($this->event->model(), $subscription);
    }
}
