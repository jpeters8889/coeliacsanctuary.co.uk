<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Rules;

use Illuminate\Contracts\Validation\Rule;
use Coeliac\Modules\Shop\Models\ShopProductVariant;

class VariantBelongsToProduct implements Rule
{
    private $productId;

    public function __construct($productId)
    {
        $this->productId = $productId;
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
