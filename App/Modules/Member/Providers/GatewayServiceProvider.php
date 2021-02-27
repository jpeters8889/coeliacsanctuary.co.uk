<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Providers;

use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\UserSubscription;
use Illuminate\Support\ServiceProvider;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Illuminate\Contracts\Auth\Access\Gate;
use Coeliac\Modules\Member\Models\Scrapbook;
use Coeliac\Modules\Member\Models\UserAddress;

class GatewayServiceProvider extends ServiceProvider
{
    public function boot()
    {
        /** @var Gate $gate */
        $gate = $this->app->make(Gate::class);

        $gate->define('view-shop-order', fn (User $user, ShopOrder $order) => $order->user_id === $user->id);
        $gate->define('modify-address', fn (User $user, UserAddress $address) => $address->user_id === $user->id);
        $gate->define('manage-scrapbook', fn (User $user, Scrapbook $scrapbook) => $scrapbook->user_id === $user->id);
        $gate->define('manage-subscription', fn(User $user, UserSubscription $subscription) => $subscription->user_id === $user->id);
    }
}
