<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Shop;

use Coeliac\Modules\Shop\Models\ShopDiscountCode;
use Coeliac\Modules\Shop\Models\ShopDiscountCodesUsed;
use Coeliac\Modules\Shop\Models\ShopDiscountCodeType;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Tests\TestCase;

class ShopDiscountCodeTest extends TestCase
{
    /** @test */
    public function itHasAType()
    {
        $code = $this->build(ShopDiscountCode::class)
            ->percentageDiscount()
            ->create();

        $this->assertEquals(ShopDiscountCodeType::PERCENTAGE, $code->type_id);
        $this->assertNotNull($code->type);
        $this->assertInstanceOf(ShopDiscountCodeType::class, $code->type);

        $code = $this->build(ShopDiscountCode::class)
            ->moneyDiscount()
            ->create();

        $this->assertEquals(ShopDiscountCodeType::MONEY, $code->type_id);
    }

    /** @test */
    public function itHasOrders()
    {
        /** @var ShopOrder $order */
        $order = $this->create(ShopOrder::class);

        /** @var ShopDiscountCode $code */
        $code = $this->create(ShopDiscountCode::class);

        ShopDiscountCodesUsed::query()->create([
            'discount_id' => $code->id,
            'order_id' => $order->id,
            'discount_amount' => 123,
        ]);

        $order = $order->fresh();

        $this->assertNotNull($order->discountCode);
        $this->assertTrue($code->is($order->discountCode));
    }

    /** @test */
    public function itCalculatesTheDiscountWhenItIsACashDiscount()
    {
        /** @var ShopDiscountCode $code */
        $code = $this->build(ShopDiscountCode::class)
            ->moneyDiscount()
            ->create(['deduction' => 100]);

        $this->assertEquals(100, $code->calculateDeduction(500));
    }

    /**
     * @test
     * @dataProvider percentageDiscounts
     */
    public function itCalculatesTheDiscountWhenItIsAPercentageDiscount($deduction, $expected, $subtotal)
    {
        /** @var ShopDiscountCode $code */
        $code = $this->build(ShopDiscountCode::class)
            ->percentageDiscount()
            ->create(['deduction' => $deduction]);

        $this->assertEquals($expected, $code->calculateDeduction($subtotal));
    }

    public function percentageDiscounts()
    {
        //[deduction, expected, subtotal]
        return [
            [15, 15, 100],
            [10, 45, 450],
            [25, 250, 1000],
        ];
    }
}
