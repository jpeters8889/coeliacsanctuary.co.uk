<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Providers;

use Coeliac\Modules\Member\Contracts\UserActivityMonitor as UserActivityContract;
use Coeliac\Modules\Member\Services\UserActivityMonitor;
use Illuminate\Contracts\Redis\Factory;
use Illuminate\Support\ServiceProvider;

class UserActivityServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->instance(UserActivityContract::class, new UserActivityMonitor(app(Factory::class)));
    }
}
