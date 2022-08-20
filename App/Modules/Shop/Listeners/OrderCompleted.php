<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Listeners;

use Coeliac\Modules\Shop\Events\CompleteOrder;
use Coeliac\Modules\Shop\Models\ShopOrderState;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderCompleted implements ShouldQueue
{
    public function handle(CompleteOrder $completeOrderEvent): void
    {
        $completeOrderEvent->order()->markAs(ShopOrderState::STATE_COMPLETE);
    }
}
