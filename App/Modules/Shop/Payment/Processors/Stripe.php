<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Payment\Processors;

use Coeliac\Modules\Shop\Exceptions\PaymentException;
use Coeliac\Modules\Shop\Payment\Processor;
use Illuminate\Http\Request;

class Stripe extends Processor
{
    public function initiatePayment(): array
    {
        $subtotal = $this->basket->subtotal();
        $discount = $this->basket->discount();
        $postage = $this->basket->postage()->calculate();

        return $this->validateIntent(
            $this->paymentProvider->initiatePayment([
                'payment_method' => $this->request->input('payment.token'),
                'amount' => $subtotal - ($discount ? $discount->calculateDeduction($subtotal) : 0) + $postage,
                'currency' => 'gbp',
                'confirmation_method' => 'manual',
                'confirm' => true,
                'metadata' => [
                    'order_id' => $this->basket->model()->id,
                ],
            ])
        );
    }

    public function processPayment(Request $request): array
    {
        return $this->validateIntent($this->paymentProvider->processPayment($request->input('payment.token')));
    }

    protected function validateIntent(object $intent): array
    {
        if (
            ($intent->status === 'requires_action' && $intent->next_action->type === 'use_stripe_sdk') ||
            ($intent->status === 'requires_source_action' && $intent->next_source_action->type === 'use_stripe_sdk')
        ) {
            return [
                'success' => false,
                'requires_action' => true,
                'payment_id' => $intent->id,
                'client_secret' => $intent->client_secret,
            ];
        }

        if ($intent->status === 'succeeded') {
            $this->basket->resolve();

            $this->submitOrderCompleteEvent('stripe', $intent);

            return [
                'success' => true,
                'requires_action' => false,
                'payment_id' => $intent->id,
                'client_secret' => $intent->client_secret,
            ];
        }

        throw new PaymentException("Couldn't validate payment intent");
    }
}
