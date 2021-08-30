<?php

declare(strict_types=1);

namespace Tests\Mocks;

use Coeliac\Modules\Shop\Payment\Provider;

class StripePaymentProvider implements Provider
{
    protected function call(...$params): mixed
    {
        $params = $params[0];

        $payment_method = is_array($params) ? $params['payment_method'] : $params;

        if ($payment_method === '123abc') {
            return json_decode(json_encode([
                'status' => 'requires_action',
                'next_action' => [
                    'type' => 'use_stripe_sdk',
                ],
                'id' => '123abc',
                'client_secret' => '123abc_secret',
            ]), false);
        }

        return json_decode(json_encode([
            'status' => 'succeeded',
            'next_action' => [],
            'id' => $payment_method,
            'client_secret' => $payment_method.'_secret',
        ]), false);
    }

    public function initiatePayment(mixed $params): mixed
    {
        return $this->call($params);
    }

    public function processPayment(mixed $params): mixed
    {
        return $this->call($params);
    }
}
