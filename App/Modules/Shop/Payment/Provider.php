<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Payment;

interface Provider
{
    public function initiatePayment(mixed $params): mixed;

    public function processPayment(mixed $params): mixed;
}
