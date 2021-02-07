<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Providers;

use Coeliac\Modules\Member\Models\User;
use Illuminate\Support\ServiceProvider;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Illuminate\Contracts\Auth\Access\Gate;

class GatewayServiceProvider extends ServiceProvider
{
    public function boot()
    {
        /** @var Gate $gate */
        $gate = $this->app->make(Gate::class);

        $gate->define('view-shop-order', fn (User $user, ShopOrder $order) => $order->user_id === $user->id);
    }
}
