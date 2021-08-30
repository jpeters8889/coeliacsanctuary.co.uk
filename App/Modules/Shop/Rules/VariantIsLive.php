<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Rules;

use Illuminate\Contracts\Validation\Rule;
use Coeliac\Modules\Shop\Models\ShopProductVariant;

class VariantIsLive implements Rule
{
    public function passes($attribute, $value)
    {
        if (!$variant = ShopProductVariant::query()->find($value)) {
            return false;
        }

        /* @var ShopProductVariant $variant */
        /** @phpstan-ignore-next-line  */
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
