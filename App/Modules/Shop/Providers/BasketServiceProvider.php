<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Providers;

use Coeliac\Modules\Shop\Basket\Basket;
use Illuminate\Foundation\Application;
use Illuminate\Session\Store;
use Illuminate\Support\ServiceProvider;

class BasketServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Basket::class, static function (Application $app) {
            return new Basket($app->make(Store::class));
        });
    }
}
