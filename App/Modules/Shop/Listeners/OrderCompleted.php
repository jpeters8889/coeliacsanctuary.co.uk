<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Coeliac\Modules\Shop\Events\CompleteOrder;
use Coeliac\Modules\Shop\Models\ShopOrderState;

class OrderCompleted implements ShouldQueue
{
    public function handle(CompleteOrder $completeOrderEvent)
    {
        $completeOrderEvent->order()->markAs(ShopOrderState::STATE_COMPLETE);
    }
}
