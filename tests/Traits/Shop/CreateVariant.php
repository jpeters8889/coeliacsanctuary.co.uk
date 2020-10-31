<?php

declare(strict_types=1);

namespace Tests\Traits\Shop;

use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopProductVariant;

trait CreateVariant
{
    protected function createVariant(ShopProduct $product, $params = [])
    {
        return factory(ShopProductVariant::class)->create(
            array_merge(
                ['product_id' => $product->id],
                $params
            )
        );
    }
}
