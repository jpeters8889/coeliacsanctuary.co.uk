<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Rules;

use Coeliac\Modules\Shop\Models\ShopProductVariant;
use Illuminate\Contracts\Validation\Rule;

class VariantInStock implements Rule
{
    /**
     * {@inheritdoc}
     */
    public function passes($attribute, $value)
    {
        /** @var ?ShopProductVariant $variant */
        $variant = ShopProductVariant::query()->find($value);

        return $variant && $variant->quantity > 0;
    }

    /**
     * {@inheritdoc}
     */
    public function message()
    {
        return 'Variant not found';
    }
}
