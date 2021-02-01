<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Shop\Order;

use Carbon\Carbon;
use Tests\TestCase;
use Tests\Traits\CreateUser;
use Coeliac\Modules\Member\Models\User;
use Tests\Traits\Shop\CreateProduct;
use Tests\Traits\Shop\CreateVariant;
use Coeliac\Modules\Member\Models\UserAddress;
use Tests\Traits\Shop\MakesShopOrders;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopPayment;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopOrderItem;
use Coeliac\Modules\Shop\Models\ShopOrderState;
use Coeliac\Modules\Shop\Models\ShopDiscountCode;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\Shop\Models\ShopProductVariant;
use Coeliac\Modules\Shop\Models\ShopDiscountCodesUsed;

class ShopOrderTest extends TestCase
{
    use RefreshDatabase;
    use MakesShopOrders;
    use CreateProduct;
    use CreateVariant;
    use CreateUser;

    /** @test */
    public function itHasAState()
    {
        /** @var ShopOrder $order */
        $order = $this->createOrder();

        $this->assertEquals(1, $order->state()->count());
        $this->assertSame(ShopOrderState::query()->first()->toArray(), $order->state->toArray());
    }

    /** @test */
    public function itHasACustomer()
    {
        /** @var User $user */
        $user = $this->createUser();

        /** @var ShopOrder $order */
        $order = $this->createOrder(['user_id' => $user->id]);

        $this->assertEquals(1, $order->user()->count());
        $this->assertSame(User::query()->latest()->first()->toArray(), $order->user->toArray());
    }

    /** @test */
    public function itHasAShippingAddress()
    {
        /** @var User $user */
        $user = $this->createUser();

        /** @var ShopOrder $order */
        $order = $this->createOrder([
            'user_id' => $user->id,
            'user_address_id' => $user->addresses()->first()->id,
        ]);

        $this->assertSame(UserAddress::query()->first()->toArray(), $order->address->toArray());
    }

    /** @test */
    public function itHasAPostageCountry()
    {
        /** @var ShopOrder $order */
        $order = $this->createOrder();

        $this->assertNotNull($order->postageCountry);
    }

    /** @test */
    public function itHasItems()
    {
        /** @var ShopOrder $order */
        $order = $this->createOrder();

        /** @var ShopProduct $product */
        $product = $this->createProduct();

        factory(ShopProductPrice::class)->create([
            'product_id' => $product->id,
            'price' => 500,
            'start_at' => Carbon::now()->subHour()->toDateTimeString(),
        ]);

        /** @var ShopProductVariant $variant */
        $variant = $this->createVariant($product);

        $item = factory(ShopOrderItem::class)->create([
            'order_id' => 1,
            'product_id' => $product->id,
            'product_variant_id' => $variant->id,
            'product_title' => $product->title,
            'product_price' => $product->currentPrice,
        ]);

//        $order->items()->create($item);

        $this->assertEquals(1, $order->items()->count());
        $this->assertSame(ShopOrderItem::query()->first()->toArray(), $order->items()->first()->toArray());
    }

    /** @test */
    public function itHasAPayment()
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
    public function itHasADiscountCode()
    {
        /** @var ShopOrder $order */
        $order = $this->createOrder();

        $this->assertNull($order->discountCode);

        /** @var ShopDiscountCode $code */
        $code = factory(ShopDiscountCode::class)->create();

        ShopDiscountCodesUsed::query()->create([
            'discount_id' => $code->id,
            'order_id' => $order->id,
            'discount_amount' => 123,
        ]);

        $order = $order->fresh();

        $this->assertNotNull($order->discountCode);
        $this->assertTrue($code->is($order->discountCode));
    }
}
