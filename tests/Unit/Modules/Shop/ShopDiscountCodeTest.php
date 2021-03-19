<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Shop;

use Tests\TestCase;
use Tests\Traits\Shop\CreateOrder;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopDiscountCode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\Shop\Models\ShopDiscountCodeType;
use Coeliac\Modules\Shop\Models\ShopDiscountCodesUsed;

class ShopDiscountCodeTest extends TestCase
{
    use RefreshDatabase;
    use CreateOrder;

    protected function createDiscountCode($params = []): ShopDiscountCode
    {
        return factory(ShopDiscountCode::class)->create($params);
    }

    /** @test */
    public function itHasAType()
    {
        $code = $this->createDiscountCode(['type_id' => ShopDiscountCodeType::PERCENTAGE]);

        $this->assertEquals(ShopDiscountCodeType::PERCENTAGE, $code->type_id);
        $this->assertNotNull($code->type);
        $this->assertInstanceOf(ShopDiscountCodeType::class, $code->type);

        $code = $this->createDiscountCode(['type_id' => ShopDiscountCodeType::MONEY]);
        $this->assertEquals(ShopDiscountCodeType::MONEY, $code->type_id);
    }

    /** @test */
    public function itHasOrders()
    {
        /** @var ShopOrder $order */
        $order = $this->createOrder();

        /** @var ShopDiscountCode $code */
        $code = $this->createDiscountCode();

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
        $code = $this->createDiscountCode(['type_id' => ShopDiscountCodeType::MONEY, 'deduction' => 100]);

        $this->assertEquals(100, $code->calculateDeduction(500));
    }

    /**
     * @test
     * @dataProvider percentageDiscounts
     */
    public function itCalculatesTheDiscountWhenItIsAPercentageDiscount($deduction, $expected, $subtotal)
    {
        /** @var ShopDiscountCode $code */
        $code = $this->createDiscountCode(['type_id' => ShopDiscountCodeType::PERCENTAGE, 'deduction' => $deduction]);

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
