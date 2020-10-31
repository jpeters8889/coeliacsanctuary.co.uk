<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Requests;

use Coeliac\Base\Requests\ApiFormRequest;
use Coeliac\Modules\Shop\Rules\DiscountIsActive;
use Coeliac\Modules\Shop\Models\ShopDiscountCode;
use Coeliac\Modules\Shop\Rules\DiscountHasAvailableClaims;

class ApplyDiscountRequest extends ApiFormRequest
{
    public function rules()
    {
        return [
            'code' => [
                'bail',
                'required',
                'alpha_num',
                'exists:shop_discount_codes,code',
                new DiscountIsActive(),
                new DiscountHasAvailableClaims(),
            ],
        ];
    }

    public function getDiscountCode(): ?ShopDiscountCode
    {
        return ShopDiscountCode::query()->firstWhere('code', $this->input('code'));
    }
}
