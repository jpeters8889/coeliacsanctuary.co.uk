<?php

declare(strict_types=1);

namespace Tests\Traits\Shop;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Tests\Traits\HasImages;
use Coeliac\Common\Models\Image;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopPayment;
use Illuminate\Foundation\Testing\WithFaker;
use Coeliac\Modules\Member\Models\UserAddress;
use Coeliac\Modules\Shop\Models\ShopOrderState;
use Coeliac\Modules\Shop\Models\ShopPaymentType;
use Coeliac\Modules\Shop\Models\ShopProductPrice;

trait MakesShopOrders
{
    use WithFaker;
    use CreateOrder;
    use HasPostageOptions;
    use CreateProduct;
    use CreateVariant;
    use HasImages;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setupPostage();
        $this->setupOrders();
        $this->makeFaker('en_GB');
    }

    private function setupOrders()
    {
        factory(ShopOrderState::class)->create(['state' => 'Basket']);
        factory(ShopOrderState::class)->create(['state' => 'Order']);
        factory(ShopOrderState::class)->create(['state' => 'Processing']);
        factory(ShopOrderState::class)->create(['state' => 'Shipped']);
        factory(ShopOrderState::class)->create(['state' => 'Complete']);
        factory(ShopOrderState::class)->create(['state' => 'Refund']);
        factory(ShopOrderState::class)->create(['state' => 'Cancelled']);

        factory(ShopPaymentType::class)->create(['type' => 'Stripe']);
        factory(ShopPaymentType::class)->create(['type' => 'PayPal']);
    }

    private function createFullOrder($params)
    {
        $product = $this->createProduct(null, ['shipping_method_id' => 1]);

        $this->createVariant($product, ['live' => 1, 'quantity' => 2]);

        factory(ShopProductPrice::class)->create([
            'product_id' => $product->id,
            'price' => 100,
            'start_at' => Carbon::now()->subHour()->toDateTimeString(),
        ]);

        $product->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_SHOP_PRODUCT);

        $token = Str::random(8);

        /** @var ShopOrder $order */
        $order = ShopOrder::query()->create(array_merge([
            'token' => $token,
            'order_key' => random_int(10000000, 99999999),
        ], $params));

        $this->withSession(['basket_token' => $token]);

        $this->post('/api/shop/basket', [
            'product_id' => $product->id,
            'variant_id' => $product->variants()->first()->id,
            'quantity' => 1,
        ]);

        ShopOrder::query()->first()->update(['state_id' => ShopOrderState::STATE_PAID]);

        ShopPayment::query()->create([
            'order_id' => 1,
            'subtotal' => 1,
            'discount' => 0,
            'postage' => 1,
            'total' => 1,
            'payment_type_id' => 1,
        ]);

        $address = UserAddress::query()->create([
            'user_id' => $order->user_id,
            'type' => 'Shipping',
            'name' => $this->faker->name,
            'postcode' => $this->faker->postcode,
            'line_1' => $this->faker->streetAddress,
            'town' => $this->faker->city,
            'country' => 'United Kingdom',
        ]);

        $order->update(['user_address_id' => $address->id]);

        return $order;
    }
}
