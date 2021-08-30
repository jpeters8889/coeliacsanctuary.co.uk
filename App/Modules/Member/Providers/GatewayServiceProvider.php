<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Providers;

use Coeliac\Modules\Member\Models\User;
use Illuminate\Support\ServiceProvider;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Illuminate\Contracts\Auth\Access\Gate;
use Coeliac\Modules\Member\Models\Scrapbook;
use Coeliac\Modules\Member\Models\UserAddress;
use Coeliac\Modules\Member\Models\UserDailyUpdateSubscription;

class GatewayServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        /** @var Gate $gate */
        $gate = $this->app->make(Gate::class);

        $gate->define('view-shop-order', fn (User $user, ShopOrder $order) => $order->user_id === $user->id);
        $gate->define('modify-address', fn (User $user, UserAddress $address) => $address->user_id === $user->id);
        $gate->define('manage-scrapbook', fn (User $user, Scrapbook $scrapbook) => $scrapbook->user_id === $user->id);
        $gate->define('manage-daily-updates', fn (User $user, UserDailyUpdateSubscription $subscription) => $subscription->user_id === $user->id);
    }
}
