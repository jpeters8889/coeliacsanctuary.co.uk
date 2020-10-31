<?php

declare(strict_types=1);

namespace Tests\Traits\Shop;

use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopCategory;

trait CreateProduct
{
    protected function createProduct($category = null, $params = []): ShopProduct
    {
        if ($category === null) {
            $category = factory(ShopCategory::class)->create();
        }

        $product = factory(ShopProduct::class)->create($params);

        if (is_array($category)) {
            foreach ($category as $cat) {
                $cat->products()->attach($product);
            }

            return $product;
        }

        $category->products()->attach($product);

        return $product;
    }
}
