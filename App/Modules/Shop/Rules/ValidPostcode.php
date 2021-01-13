<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Rules;

use Illuminate\Container\Container;
use Coeliac\Modules\Shop\Basket\Basket;
use Illuminate\Contracts\Validation\Rule;
use Coeliac\Modules\Shop\Models\ShopPostageCountry;

class ValidPostcode implements Rule
{
    public function passes($attribute, $value)
    {
        /** @var Basket $basket */
        $basket = Container::getInstance()->make(Basket::class);

        if ($basket->resolve() && $basket->model()->postage_country_id === ShopPostageCountry::UK) {
            return preg_match('/^[A-Z]{1,2}\d[A-Z\d]? ?\d[A-Z]{2}$/i', $value);
        }

        return true;
    }

    public function message()
    {
        return 'Invalid UK Postcode';
    }
}
