<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;
use Coeliac\Base\Requests\ApiFormRequest;
use Coeliac\Modules\Shop\Rules\ValidPostcode;

class OrderRequest extends ApiFormRequest
{
    public function rules(): array
    {
        $userRules = [];

        if (!$this->user()) {
            $userRules = [
                'user' => ['required', 'array'],
                'user.name' => ['required'],
                'user.email' => ['required', 'email'],
                'user.emailConfirmation' => ['required', 'email', 'same:user.email'],
            ];
        }

        return array_merge($userRules, [
            'shipping' => ['required', 'array'],
            'shipping.id' => [
                'required_without:shipping.address1,shipping.town,shipping.postcode',
                'bail',
                'nullable',
                Rule::exists('user_addresses', 'id')->where(function (Builder $query) {
                    $query->where('user_id', $this->user()->id);
                }),
            ],
            'shipping.address1' => ['required_without:shipping.id'],
            'shipping.town' => ['required_without:shipping.id'],
            'shipping.postcode' => ['required_without:shipping.id', new ValidPostcode()],

            'billing' => ['required', 'array'],
            'billing.id' => [
                'required_without:billing.name,billing.address1,billing.town,billing.postcode,billing.country',
                'bail',
                'nullable',
                Rule::exists('user_addresses', 'id')->where(function (Builder $query) {
                    $query->where('user_id', $this->user()->id);
                }),
            ],
            'billing.name' => ['required_without:billing.id'],
            'billing.address1' => ['required_without:billing.id'],
            'billing.town' => ['required_without:billing.id'],
            'billing.postcode' => ['required_without:billing.id'],
            'billing.country' => ['required_without:billing.id'],

            'payment' => ['required', 'array'],
            'payment.provider' => ['required', 'in:stripe,paypal'],
            'payment.token' => ['required_if:payment.provider,stripe'],
        ]);
    }
}
