<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Requests;

use Coeliac\Base\Requests\ApiFormRequest;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Rules\ProductIsLive;
use Coeliac\Modules\Shop\Rules\VariantIsLive;
use Coeliac\Modules\Shop\Models\ShopProductVariant;
use Coeliac\Modules\Shop\Rules\VariantBelongsToProduct;

class BasketUpdateRequest extends ApiFormRequest
{
    public function rules()
    {
        return [
            'product' => ['required', 'exists:shop_products,id', new ProductIsLive()],
            'variant' => [
                'required',
                'exists:shop_product_variants,id',
                new VariantIsLive(),
                new VariantBelongsToProduct($this->input('product')),
            ],
            'action' => ['required', 'in:increase,decrease'],
        ];
    }

    public function resolveProduct(): ShopProduct
    {
        return ShopProduct::query()->where('id', $this->input('product'))->first();
    }

    public function resolveVariant(): ShopProductVariant
    {
        return ShopProductVariant::query()->where('id', $this->input('variant'))->first();
    }
}
