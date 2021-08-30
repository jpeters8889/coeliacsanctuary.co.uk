<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Console;

use Coeliac\Modules\Blog\Models\Blog;
use Illuminate\Console\Command;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\DailyUpdatesQueue;
use Coeliac\Modules\Member\Notifications\DailyUpdate;
use Coeliac\Modules\Member\Services\DailyUpdatePreprocessor;
use Coeliac\Modules\Member\Models\UserDailyUpdateSubscription;

class SendDailyUpdates extends Command
{
    protected $signature = 'coeliac:send_daily_updates';

    public function handle(): void
    {
        DailyUpdatesQueue::query()
            ->with(['newItem'])
            ->get()
            ->groupBy(function (DailyUpdatesQueue $updatesQueue) {
                return $updatesQueue['user_id'];
            })
            ->each(function ($updates, $userId) {
                /** @var User $user */
                $user = User::query()
                    ->with(['subscriptions', 'subscriptions.updatable'])
                    ->find($userId);

                $updateProcessor = new DailyUpdatePreprocessor(
                    $user->subscriptions->map(fn (UserDailyUpdateSubscription $subscription) => $subscription->updatable),
                    $updates->map(fn (DailyUpdatesQueue $queue) => $queue->newItem()->first())
                );

                $user->notify(new DailyUpdate($updateProcessor));

                $updates->map(fn (DailyUpdatesQueue $queue) => $queue->delete());
            });
    }
}
