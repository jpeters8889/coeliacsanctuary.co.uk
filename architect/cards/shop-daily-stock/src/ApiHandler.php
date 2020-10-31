<?php

declare(strict_types=1);

namespace Coeliac\Architect\Cards\ShopDailyStock;

use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopOrderItem;
use Coeliac\Modules\Shop\Models\ShopOrderState;

class ApiHandler
{
    public function handle()
    {
        $items = [];

        ShopOrder::query()
            ->whereIn('state_id', [ShopOrderState::STATE_PAID, ShopOrderState::STATE_PRINTED])
            ->with(['items', 'items.product', 'items.variant'])
            ->get()
            ->each(static function (ShopOrder $order) use (&$items) {
                $order->items()->each(static function (ShopOrderItem $item) use (&$items) {
                    if (array_key_exists($item->variant->id, $items)) {
                        $items[$item->variant->id]['quantity'] += $item->quantity;

                        return;
                    }

                    $items[$item->variant->id] = [
                        'quantity' => $item->quantity,
                        'item' => $item->makeVisible(['product', 'variant', 'product_title']),
                    ];
                });
            });

        $return = [];

        foreach ($items as $product) {
            if (!array_key_exists($product['item']->product->categories[0]->title, $return)) {
                $return[$product['item']->product->categories[0]->title] = [];
            }

            $return[$product['item']->product->categories[0]->title][$product['item']->product_title] = $product['quantity'];
        }

        return $return;
    }
}
