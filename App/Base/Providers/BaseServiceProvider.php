<?php

declare(strict_types=1);

namespace Coeliac\Base\Providers;

use Coeliac\Base\Models\BaseModel;
use Coeliac\Common\Providers\ArchitectServiceProvider;
use Coeliac\Common\Providers\CoeliacServiceProvider;
use Illuminate\Support\ServiceProvider;

class BaseServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        BaseModel::preventLazyLoading(! $this->app->isProduction() && !$this->app->runningInConsole());
    }

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
