<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Providers;

use Illuminate\Contracts\Redis\Factory;
use Illuminate\Support\ServiceProvider;
use Coeliac\Modules\Member\Services\UserActivityMonitor;
use Coeliac\Modules\Member\Contracts\UserActivityMonitor as UserActivityContract;

class UserActivityServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->instance(UserActivityContract::class, new UserActivityMonitor(app(Factory::class)));
    }
}
