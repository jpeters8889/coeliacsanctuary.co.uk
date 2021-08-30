<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Console;

use Illuminate\Console\Command;
use Coeliac\Modules\Member\Contracts\UserActivityMonitor;

class UpdateUserActivity extends Command
{
    protected $signature = 'coeliac:update-user-activity';

    public function handle(UserActivityMonitor $activityMonitor): void
    {
        $activityMonitor->all()
            ->each(fn ($item) => $item['user']->update(['last_visited_at' => $item['date']]))
            ->each(fn ($item) => $activityMonitor->delete($item['user']));
    }
}
