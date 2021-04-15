<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Rules;

use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Rule;

class ValidShippingPostcode implements Rule
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

        if ($this->request->input('country') !== 'United Kingdom') {
            return true;
        }

        return preg_match('/^[A-Z]{1,2}\d[A-Z\d]? ?\d[A-Z]{2}$/i', $value);
    }

    public function message()
    {
        return 'The postcode must be a valid UK Postcode';
    }
}
