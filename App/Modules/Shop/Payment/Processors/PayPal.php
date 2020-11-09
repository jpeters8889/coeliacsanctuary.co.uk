<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Payment\Processors;

use Exception;
use Illuminate\Http\Request;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Coeliac\Modules\Shop\Payment\Processor;
use Coeliac\Modules\Shop\Exceptions\PaymentException;

class PayPal extends Processor
{
    public function initiatePayment()
    {
        try {
            return $this->paymentProvider->initiatePayment($this->basket);
        } catch (Exception $exception) {
            Bugsnag::notifyException($exception);
            throw new PaymentException("Couldn't initiate PayPal payment.");
        }
    }

    public function processPayment(Request $request)
    {
        try {
            $return = $this->paymentProvider->processPayment($request);

            $this->basket->resolve();

            $this->submitOrderCompleteEvent('paypal', $return);

            return $return;
        } catch (Exception $exception) {
            Bugsnag::notifyException($exception);
            throw new PaymentException("Couldn't process PayPal payment");
        }
    }
}
