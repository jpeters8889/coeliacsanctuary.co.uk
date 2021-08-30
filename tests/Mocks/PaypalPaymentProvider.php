<?php

declare(strict_types=1);

namespace Tests\Mocks;

use Coeliac\Modules\Shop\Payment\Provider;

class PaypalPaymentProvider implements Provider
{
    public function call(): mixed
    {
        return ['status' => 'succeeded'];
    }

    public function initiatePayment(mixed $params): mixed
    {
        return $this->call();
    }

    public function processPayment(mixed $params): mixed
    {
        return $this->call();
    }
}
