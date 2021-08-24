<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Basket;

use Coeliac\Modules\Shop\Models\ShopOrderItem;
use Coeliac\Modules\Shop\Exceptions\BasketException;

class Postage
{
    private Basket $basket;

    public function __construct(Basket $basket)
    {
        $this->basket = $basket;
    }

    public function calculate()
    {
        $postageArea = $this->basket->model()->postageCountry->area;

        $weight = 0;
        $shippingMethod = 1;

        $this->basket->model()->items()->with(['product', 'variant', 'product.shippingMethod'])
            ->each(static function (ShopOrderItem $item) use (&$weight, &$shippingMethod) {
                $weight += $item->variant->weight * $item->quantity;

                if ($item->product->shippingMethod->id > $shippingMethod) {
                    $shippingMethod = $item->product->shippingMethod->id;
                }
            });

        $postage = $postageArea->postagePrices()
            ->where('max_weight', '>=', $weight)
            ->where('shipping_method_id', $shippingMethod)
            ->orderBy('max_weight')
            ->first();

        if (!$postage) {
            throw new BasketException("Can't find postage option");
        }

        return $postage->price;
    }
}
