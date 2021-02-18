<?php

namespace Coeliac\Modules\Member\Requests;

use Coeliac\Base\Requests\ApiFormRequest;
use Coeliac\Modules\Member\Rules\ValidShippingCountry;
use Coeliac\Modules\Member\Rules\ValidShippingPostcode;

class UpdateAddressRequest extends ApiFormRequest
{
    public function rules()
    {
        return [
            'type' => ['required', 'in:Shipping,Billing'],
            'name' => ['required'],
            'line_1' => ['required'],
            'line_2' => ['nullable'],
            'line_3' => ['nullable'],
            'town' => ['required'],
            'postcode' => ['required', new ValidShippingPostcode($this)],
            'country' => ['required', new ValidShippingCountry($this)],
        ];
    }
}
