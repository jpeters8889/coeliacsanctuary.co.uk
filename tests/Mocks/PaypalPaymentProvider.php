<?php

declare(strict_types=1);

namespace Tests\Mocks;

use Coeliac\Modules\Shop\Payment\Provider;

class PaypalPaymentProvider implements Provider
{
    public function call()
    {
        return ['status' => 'succeeded'];
    }

    public function initiatePayment($params)
    {
        return $this->call();
    }

    public function processPayment($params)
    {
        return $this->call();
    }
}
