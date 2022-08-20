<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Rules;

use Coeliac\Modules\Shop\Models\ShopDiscountCode;
use Illuminate\Contracts\Validation\Rule;

class DiscountHasAvailableClaims implements Rule
{
    public function passes($attribute, $value)
    {
        /** @var ShopDiscountCode $code */
        $code = ShopDiscountCode::query()->firstWhere('code', $value);

        return ! ($code->max_claims > 0 && $code->orders()->count() >= $code->max_claims);
    }

    public function message()
    {
        return 'Discount code has been claimed too many times.';
    }
}
