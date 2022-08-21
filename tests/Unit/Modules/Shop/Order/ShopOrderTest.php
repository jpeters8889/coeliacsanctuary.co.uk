<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Shop\Order;

use Coeliac\Modules\Member\Models\UserAddress;
use Coeliac\Modules\Shop\Models\ShopDiscountCode;
use Coeliac\Modules\Shop\Models\ShopDiscountCodesUsed;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopOrderItem;
use Coeliac\Modules\Shop\Models\ShopOrderState;
use Coeliac\Modules\Shop\Models\ShopPayment;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Coeliac\Modules\Shop\Models\ShopProductVariant;
use Tests\TestCase;

class ShopOrderTest extends TestCase
{
    protected ShopOrder $order;

    protected function setUp(): void
    {
        parent::setUp();

        $this->order = $this->create(ShopOrder::class);
    }

    /** @test */
    public function itHasAState()
    {
        $this->assertEquals(1, $this->order->state()->count());
        $this->assertSame(ShopOrderState::query()->first()->toArray(), $this->order->state->toArray());
    }

    /** @test */
    public function itHasACustomer()
    {
        $this->assertEquals(1, $this->order->user()->count());
    }

    /** @test */
    public function itHasAShippingAddress()
    {
        $this->assertSame(UserAddress::query()->first()->toArray(), $this->order->fresh()->address->toArray());
    }

    /** @test */
    public function itHasAPostageCountry()
    {
        $this->assertNotNull($this->order->postageCountry);
    }

    /** @test */
    public function itHasItems()
    {
        $this->build(ShopOrderItem::class)
            ->to($this->order)
            ->add($this->build(ShopProductVariant::class)
            ->in($this->build(ShopProduct::class)
            ->has($this->build(ShopProductPrice::class)->state(['price' => 100]), 'prices')
            ->create())
            ->create(['weight' => 10]))
            ->create();

        $this->assertEquals(1, $this->order->items()->count());
        $this->assertSame(ShopOrderItem::query()->first()->toArray(), $this->order->items()->first()->toArray());
    }

    /** @test */
    public function itHasAPayment()
    {
        /** @var ShopPayment $payment */
        $payment = ShopPayment::query()->create([
            'order_id' => $this->order->id,
            'subtotal' => 200,
            'discount' => 0,
            'postage' => 100,
            'total' => 300,
            'payment_type_id' => 1,
        ]);

        $this->assertSame($payment->order->toArray(), $this->order->fresh()->toArray());
    }

    /** @test */
    public function itHasADiscountCode()
    {
        $this->assertNull($this->order->discountCode);

        /** @var ShopDiscountCode $code */
        $code = $this->create(ShopDiscountCode::class);

        ShopDiscountCodesUsed::query()->create([
            'discount_id' => $code->id,
            'order_id' => $this->order->id,
            'discount_amount' => 123,
        ]);

        $order = $this->order->fresh();

        $this->assertNotNull($order->discountCode);
        $this->assertTrue($code->is($order->discountCode));
    }
}
