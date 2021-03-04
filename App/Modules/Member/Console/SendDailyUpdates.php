<?php

namespace Coeliac\Modules\Member\Console;

use Coeliac\Modules\Member\Models\DailyUpdatesQueue;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Notifications\DailyUpdate;
use Illuminate\Console\Command;

class SendDailyUpdates extends Command
{
    protected $signature = 'coeliac:send_daily_updates';

    public function handle()
    {
        $updates = DailyUpdatesQueue::query()
            ->get()
            ->groupBy(function (DailyUpdatesQueue $updatesQueue) {
                return $updatesQueue['user_id'];
            });

//        dd($updates);

        $updates->each(function($updates, $userId) {
            /** @var User $user */
            $user = User::query()->find($userId);

            $user->notify(new DailyUpdate());
        });

    }
}
