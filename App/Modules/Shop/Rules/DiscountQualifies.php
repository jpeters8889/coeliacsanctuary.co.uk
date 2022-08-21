<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Rules;

use Coeliac\Modules\Shop\Basket\Basket;
use Coeliac\Modules\Shop\Models\ShopDiscountCode;
use Illuminate\Container\Container;
use Illuminate\Contracts\Validation\Rule;

class DiscountQualifies implements Rule
{
    public function passes($attribute, $value)
    {
        /** @var Basket $basket */
        $basket = Container::getInstance()->make(Basket::class);

        /** @var ShopDiscountCode $code */
        $code = ShopDiscountCode::query()->firstWhere('code', $value);

        if (! $basket->resolve()) {
            return false;
        }

        $subtotal = array_sum($basket->model()->items()->get()->pluck('subtotal')->toArray());

        return ! ($code->min_spend && $subtotal < $code->min_spend);
    }

    public function message()
    {
        return 'Minimum spend not met';
    }
}
