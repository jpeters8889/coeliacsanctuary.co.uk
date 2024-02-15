<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Requests;

use Coeliac\Base\Requests\ApiFormRequest;
use Coeliac\Modules\Shop\Models\ShopDiscountCode;
use Coeliac\Modules\Shop\Rules\DiscountHasAvailableClaims;
use Coeliac\Modules\Shop\Rules\DiscountIsActive;
use Coeliac\Modules\Shop\Rules\DiscountQualifies;

class ApplyDiscountRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'code' => [
                'bail',
                'required',
                'string',
                'exists:shop_discount_codes,code',
                new DiscountIsActive(),
                new DiscountHasAvailableClaims(),
                new DiscountQualifies(),
            ],
        ];
    }

    public function getDiscountCode(): ?ShopDiscountCode
    {
        return ShopDiscountCode::query()->firstWhere('code', $this->input('code'));
    }
}
