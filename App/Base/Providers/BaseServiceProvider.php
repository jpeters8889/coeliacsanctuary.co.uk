<?php

declare(strict_types=1);

namespace Coeliac\Base\Providers;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Support\ServiceProvider;
use Coeliac\Common\Providers\CoeliacServiceProvider;
use Coeliac\Common\Providers\ArchitectServiceProvider;

class BaseServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        BaseModel::preventLazyLoading(! $this->app->isProduction());
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
