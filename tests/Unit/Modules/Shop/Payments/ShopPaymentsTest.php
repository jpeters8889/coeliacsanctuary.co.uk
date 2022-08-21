<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Shop\Payments;

use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopPayment;
use Coeliac\Modules\Shop\Models\ShopPaymentResponse;
use Tests\TestCase;

class ShopPaymentsTest extends TestCase
{
    protected ShopOrder $order;

    protected function setUp(): void
    {
        parent::setUp();

        $this->order = $this->build(ShopOrder::class)
            ->has($this->build(ShopPayment::class), 'payment')
            ->create();
    }

    /** @test */
    public function itIsLinkedToAnOrder()
    {
        $this->assertTrue(ShopPayment::query()->first()->order->is($this->order));
    }

    /** @test */
    public function itHasAPaymentType()
    {
        $this->assertEquals('Stripe', $this->order->payment->type->type);
    }

    /** @test */
    public function itHasAResponse()
    {
        $response = $this->create(ShopPaymentResponse::class, [
            'payment_id' => $this->order->payment->id,
        ]);

        $this->assertEquals($response->toArray(), $this->order->payment->response->toArray());
    }
}
