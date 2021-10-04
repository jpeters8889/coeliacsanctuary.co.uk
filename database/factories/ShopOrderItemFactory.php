<?php

namespace Database\Factories;

use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopOrderItem;
use Coeliac\Modules\Shop\Models\ShopProductVariant;

class ShopOrderItemFactory extends Factory
{
    protected $model = ShopOrderItem::class;

    public function definition()
    {
        return [
            'quantity' => 1,
        ];
    }

    public function to(ShopOrder $order)
    {
        return $this->state(fn () => ['order_id' => $order->id]);
    }

    public function add(ShopProductVariant|int $productVariant, ?ShopProductVariant $param = null)
    {
        $quantity = 1;

        if ($param) {
            $quantity = $productVariant;
            $productVariant = $param;
        }

        return $this->state(fn () => [
            'product_id' => $productVariant->product->id,
            'product_variant_id' => $productVariant->id,
            'product_title' => $productVariant->product->title,
            'product_price' => $productVariant->product->currentPrice,
            'quantity' => $quantity,
        ]);
    }
}
