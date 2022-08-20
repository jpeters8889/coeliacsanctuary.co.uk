<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Rules;

use Coeliac\Modules\Shop\Models\ShopProductVariant;
use Illuminate\Contracts\Validation\Rule;

class VariantIsLive implements Rule
{
    public function passes($attribute, $value)
    {
        if (! $variant = ShopProductVariant::query()->find($value)) {
            return false;
        }

        /* @var ShopProductVariant $variant */
        return $variant->live === true;
    }

    /**
     * {@inheritdoc}
     */
    public function message()
    {
        return 'Product not found';
    }
}
