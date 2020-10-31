<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;
use Coeliac\Modules\Shop\Models\ShopDiscountCode;

class DiscountIsActive implements Rule
{
    public function passes($attribute, $value)
    {
        /** @var ShopDiscountCode $discount */
        $discount = ShopDiscountCode::query()->where('code', $value)->first();

        $now = Carbon::now();

        if ($now->lessThan($discount->start_at) || $now->greaterThan($discount->end_at)) {
            return false;
        }

        return true;
    }

    public function message()
    {
        return 'Discount code is not active';
    }
}
