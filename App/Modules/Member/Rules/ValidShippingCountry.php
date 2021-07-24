<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Rules;

use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Rule;
use Coeliac\Modules\Shop\Models\ShopPostageCountry;

class ValidShippingCountry implements Rule
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function passes($attribute, $value)
    {
        if ($this->request->missing('type') || $this->request->input('type') !== 'Shipping') {
            return true;
        }

        return ShopPostageCountry::query()->where('country', $value)->exists();
    }

    public function message()
    {
        return 'Please select a valid country for shipping';
    }
}
