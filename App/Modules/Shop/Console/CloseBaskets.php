<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Console;

use Carbon\Carbon;
use Coeliac\Modules\Shop\Events\BasketClosed;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopOrderState;
use Illuminate\Console\Command;
use Illuminate\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;

class CloseBaskets extends Command
{
    protected $signature = 'coeliac:shopCloseBaskets';

    public function handle(): void
    {
        ShopOrder::query()
            ->where('state_id', ShopOrderState::STATE_BASKET)
            ->where('updated_at', '<', Carbon::now()->subHour())
            ->get()
            ->each(function (ShopOrder $order) {
                $order->markAs(ShopOrderState::STATE_EXPIRED);

                Container::getInstance()->make(Dispatcher::class)->dispatch(new BasketClosed($order));
            });
    }
}
