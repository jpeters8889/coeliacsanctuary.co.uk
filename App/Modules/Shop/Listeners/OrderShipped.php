<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Listeners;

use Illuminate\Container\Container;
use Coeliac\Modules\Shop\Events\ShipOrder;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Queue\ShouldQueue;
use Coeliac\Modules\Shop\Events\CompleteOrder;
use Coeliac\Modules\Shop\Models\ShopOrderState;
use Coeliac\Modules\Shop\Notifications\OrderShippedNotification;

class OrderShipped implements ShouldQueue
{
    public function handle(ShipOrder $shipOrderEvent)
    {
        $shipOrderEvent->order()->markAs(ShopOrderState::STATE_SHIPPED);

        $shipOrderEvent->order()->user->notify(new OrderShippedNotification($shipOrderEvent->order()));

        Container::getInstance()->make(Dispatcher::class)->dispatch(new CompleteOrder($shipOrderEvent->order()));
    }
}
