<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Rules;

use Coeliac\Modules\Shop\Models\ShopProductVariant;
use Illuminate\Contracts\Validation\Rule;

class VariantBelongsToProduct implements Rule
{
    public function __construct(private int $productId)
    {
        //
    }

    /**
     * {@inheritdoc}
     */
    public function passes($attribute, $value)
    {
        /** @var ?ShopProductVariant $variant */
        $variant = ShopProductVariant::query()->find($value);

        return $variant && $variant->product->id === $this->productId;
    }

    /**
     * {@inheritdoc}
     */
    public function message()
    {
        return 'Variant not found';
    }
}
