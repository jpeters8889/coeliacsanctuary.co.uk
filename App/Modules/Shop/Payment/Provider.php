<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Payment;

interface Provider
{
    public function initiatePayment($params);

    public function processPayment($params);
}
