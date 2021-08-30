<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Coeliac\Modules\Shop\Events\CancelOrder;
use Coeliac\Modules\Shop\Models\ShopOrderState;
use Coeliac\Modules\Shop\Notifications\OrderCancelledNotification;

class OrderCancelled implements ShouldQueue
{
    public function handle(CancelOrder $cancelOrderEvent): void
    {
        $cancelOrderEvent->order()->markAs(ShopOrderState::STATE_CANCELLED);

        $cancelOrderEvent->order()->user->notify(new OrderCancelledNotification($cancelOrderEvent->order()));
    }
}
