<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Requests;

use Coeliac\Base\Requests\ApiFormRequest;

class OrderUpdateRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'payment' => ['required', 'array'],
            'payment.provider' => ['required', 'in:stripe,paypal'],
            'payment.token' => ['required_if:payment.provider,stripe'],
        ];
    }
}
