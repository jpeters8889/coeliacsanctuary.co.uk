<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Requests;

use Coeliac\Base\Requests\ApiFormRequest;
use Coeliac\Modules\Shop\Rules\ReviewedProductIsInOrder;
use Illuminate\Validation\Rule;

class ReviewMyOrderRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['string'],
            'whereHeard' => ['array'],
            'whereHeard.*' => ['string'],
            'products' => ['required', 'array'],
            'products.*.id' => ['required', 'int', 'bail', 'exists:shop_products,id', new ReviewedProductIsInOrder()],
            'products.*.rating' => ['required', 'numeric', Rule::in(range(1, 5))],
            'products.*.review' => ['string', 'nullable'],
        ];
    }
}
