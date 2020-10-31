<?php

declare(strict_types=1);

namespace Coeliac\Base\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Coeliac\Common\Providers\CoeliacServiceProvider;
use Coeliac\Common\Providers\ArchitectServiceProvider;

class BaseServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->register(ArchitectServiceProvider::class);
        $this->app->register(CoeliacServiceProvider::class);
        $this->app->register(HorizonServiceProvider::class);
    }
}
