<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Rules;

use Illuminate\Contracts\Validation\Rule;
use Coeliac\Modules\Shop\Models\ShopProduct;

class ProductIsLive implements Rule
{
    /**
     * {@inheritdoc}
     */
    public function passes($attribute, $value)
    {
        if (!$product = ShopProduct::query()->find($value)) {
            return false;
        }

        /** @var ShopProduct $product */
        return in_array(true, $product->variants->pluck('live')->toArray());
    }

    /**
     * {@inheritdoc}
     */
    public function message()
    {
        return 'Product not found';
    }
}
