<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Console;

use Illuminate\Console\Command;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\DailyUpdatesQueue;
use Coeliac\Modules\Member\Notifications\DailyUpdate;
use Coeliac\Modules\Member\Services\DailyUpdatePreprocessor;
use Coeliac\Modules\Member\Models\UserDailyUpdateSubscription;

class SendDailyUpdates extends Command
{
    protected $signature = 'coeliac:send_daily_updates';

    public function handle()
    {
        DailyUpdatesQueue::query()
            ->get()
            ->groupBy(function (DailyUpdatesQueue $updatesQueue) {
                return $updatesQueue['user_id'];
            })
            ->each(function ($updates, $userId) {
                /** @var User $user */
                $user = User::query()->find($userId);

                $updateProcessor = new DailyUpdatePreprocessor(
                    $user->subscriptions->map(fn (UserDailyUpdateSubscription $subscription) => $subscription->updatable),
                    $updates->map(fn (DailyUpdatesQueue $queue) => $queue->newItem)
                );

                $user->notify(new DailyUpdate($updateProcessor));

                $updates->map(fn (DailyUpdatesQueue $queue) => $queue->delete());
            });
    }
}
