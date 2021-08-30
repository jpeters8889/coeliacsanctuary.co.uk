<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Payment\Providers;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Container\Container;
use Coeliac\Modules\Shop\Payment\Provider;
use Illuminate\Contracts\Config\Repository;

class StripePaymentProvider implements Provider
{
    public function __construct()
    {
        Stripe::setApiKey(Container::getInstance()->make(Repository::class)->get('services.shop.payments.stripe.secret'));
    }

    public function initiatePayment(mixed $params): PaymentIntent
    {
        return PaymentIntent::create($params);
    }

    public function processPayment(mixed $params): PaymentIntent
    {
        return PaymentIntent::retrieve($params)->confirm();
    }
}
