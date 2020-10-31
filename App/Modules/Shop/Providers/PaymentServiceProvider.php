<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Providers;

use Illuminate\Http\Request;
use Illuminate\Container\Container;
use PayPal\Auth\OAuthTokenCredential;
use Coeliac\Modules\Shop\Basket\Basket;
use Illuminate\Support\ServiceProvider;
use Coeliac\Modules\Shop\Payment\Processor;
use Illuminate\Contracts\Config\Repository;
use Coeliac\Modules\Shop\Requests\OrderRequest;
use PayPal\Rest\ApiContext as PaypalApiContext;
use Coeliac\Modules\Shop\Payment\Processors\PayPal;
use Coeliac\Modules\Shop\Payment\Processors\Stripe;
use Coeliac\Modules\Shop\Payment\Providers\PayPalPaymentProvider;
use Coeliac\Modules\Shop\Payment\Providers\StripePaymentProvider;

class PaymentServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind(Processor::class, static function () {
            /** @var OrderRequest $request */
            $request = Container::getInstance()->make(Request::class);

            $class = Stripe::class;
            $provider = StripePaymentProvider::class;

            if ($request->input('payment.provider') === 'paypal') {
                $class = PayPal::class;
                $provider = PayPalPaymentProvider::class;
            }

            return new $class(resolve(Basket::class), resolve($provider));
        });
    }

    public function register()
    {
        $this->app->instance(PayPalPaymentProvider::class, new PayPalPaymentProvider(
            new PaypalApiContext(
                new OAuthTokenCredential(
                    Container::getInstance()->make(Repository::class)->get('services.shop.payments.paypal.client'),
                    Container::getInstance()->make(Repository::class)->get('services.shop.payments.paypal.secret')
                )
            )
        ));
    }
}
