<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Listeners;

use Coeliac\Modules\Shop\Events\BasketClosed;
use Coeliac\Modules\Shop\Models\ShopOrderItem;

class ResetStock
{
    public function handle(BasketClosed $event)
    {
        $event->order()->items()->get()
            ->each(static function (ShopOrderItem $item) {
                $item->variant->increment('quantity', $item->quantity);
            });
    }
}
