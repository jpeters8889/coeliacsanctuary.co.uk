<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Requests;

use Coeliac\Base\Requests\ApiFormRequest;
use Coeliac\Modules\Shop\Rules\ValidPostcode;

class OrderRequest extends ApiFormRequest
{
    public function rules()
    {
        return [
            'user' => ['required', 'array'],
            'user.name' => ['required'],
            'user.email' => ['required', 'email'],
            'user.emailConfirmation' => ['required', 'email', 'same:user.email'],

            'shipping' => ['required', 'array'],
            'shipping.address1' => ['required'],
            'shipping.town' => ['required'],
            'shipping.postcode' => ['required', new ValidPostcode()],

            'billing' => ['required', 'array'],
            'billing.name' => ['required'],
            'billing.address1' => ['required'],
            'billing.town' => ['required'],
            'billing.postcode' => ['required'],
            'billing.country' => ['required'],

            'payment' => ['required', 'array'],
            'payment.provider' => ['required', 'in:stripe,paypal'],
            'payment.token' => ['required_if:payment.provider,stripe'],
        ];
    }
}
