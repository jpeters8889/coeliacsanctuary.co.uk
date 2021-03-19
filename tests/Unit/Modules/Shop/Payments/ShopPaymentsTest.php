<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Shop\Payments;

use Tests\TestCase;
use Tests\Traits\Shop\MakesShopOrders;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopPayment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\Shop\Models\ShopPaymentResponse;

class ShopPaymentsTest extends TestCase
{
    use RefreshDatabase;
    use MakesShopOrders;

    /** @test */
    public function itIsLinkedToAnOrder()
    {
        /** @var ShopOrder $order */
        $order = $this->createOrder();

        /** @var ShopPayment $payment */
        $payment = ShopPayment::query()->create([
            'order_id' => $order->id,
            'subtotal' => 200,
            'discount' => 0,
            'postage' => 100,
            'total' => 300,
            'payment_type_id' => 1,
        ]);

        $order = $order->fresh();

        $this->assertSame($payment->order->toArray(), $order->toArray());
    }

    /** @test */
    public function itHasAPaymentType()
    {
        /** @var ShopOrder $order */
        $order = $this->createOrder();

        /** @var ShopPayment $payment */
        $payment = ShopPayment::query()->create([
            'order_id' => $order->id,
            'subtotal' => 200,
            'discount' => 0,
            'postage' => 100,
            'total' => 300,
            'payment_type_id' => 1,
        ]);

        $this->assertEquals('Stripe', $payment->type->type);
    }

    /** @test */
    public function itHasAResponse()
    {
        /** @var ShopOrder $order */
        $order = $this->createOrder();

        /** @var ShopPayment $payment */
        $payment = ShopPayment::query()->create([
            'order_id' => $order->id,
            'subtotal' => 200,
            'discount' => 0,
            'postage' => 100,
            'total' => 300,
            'payment_type_id' => 1,
        ]);

        $response = factory(ShopPaymentResponse::class)->create([
            'payment_id' => $payment->id,
        ]);

        $this->assertEquals($response->toArray(), $payment->response->toArray());
    }
}
