<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Shop\Order;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Str;
use Tests\Traits\HasImages;
use Illuminate\Session\Store;
use Coeliac\Common\Models\Image;
use Tests\Traits\Shop\CreateProduct;
use Tests\Traits\Shop\CreateVariant;
use Illuminate\Support\Facades\Event;
use Tests\Traits\Shop\MakesShopOrders;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Shop\Basket\Basket;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Events\CreateOrder;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Illuminate\Support\Facades\Notification;
use Coeliac\Modules\Member\Models\UserAddress;
use Coeliac\Modules\Shop\Models\ShopOrderItem;
use Coeliac\Modules\Shop\Models\ShopOrderState;
use Coeliac\Modules\Shop\Models\ShopDiscountCode;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\Shop\Models\ShopProductVariant;
use Coeliac\Modules\Shop\Notifications\OrderCreatedNotification;

class ShopOrderCreatedEventTest extends TestCase
{
    use MakesShopOrders;
    use RefreshDatabase;
    use CreateVariant;
    use CreateProduct;
    use HasImages;

    /**
     * @var ShopProductVariant
     */
    private $variant;

    /**
     * @var ShopProduct
     */
    private $product;

    /**
     * @var Basket
     */
    private $basket;

    /**
     * @var ShopOrder
     */
    private $order;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        Notification::fake();

        $this->setupPostage();
        $this->setupOrders();

        $this->product = $this->createProduct(null, ['shipping_method_id' => 1]);
        $this->variant = $this->createVariant($this->product, ['weight' => 10]);

        $this->user = factory(User::class)->create([
            'email' => 'foo@bar.com',
            'name' => 'Foo Bar',
        ]);

        $this->createAdminUser();

        factory(UserAddress::class)->create([
            'user_id' => 1,
            'type' => 'Shipping',
        ]);

        factory(ShopProductPrice::class)->create([
            'product_id' => $this->product->id,
            'price' => 100,
            'start_at' => Carbon::now()->subHour()->toDateTimeString(),
        ]);

        $this->product->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_SHOP_PRODUCT);

        $token = Str::random(8);

        $this->order = ShopOrder::query()->create([
            'token' => $token,
            'postage_country_id' => 1,
            'user_id' => 1,
            'user_address_id' => 1,
            'newsletter_signup' => true,
        ]);

        $sessionStore = $this->app->make(Store::class);

        $sessionStore->push('basket_token', $token);

        ShopOrderItem::query()->create([
            'order_id' => 1,
            'product_id' => $this->product->id,
            'product_variant_id' => $this->variant->id,
            'quantity' => 1,
            'product_title' => $this->product->title,
            'product_price' => $this->product->currentPrice,
        ]);

        $this->basket = new Basket($sessionStore);

        $this->basket->resolve();

        $this->order = $this->order->fresh();
    }

    private function dispatchOrder()
    {
        Event::dispatch(new CreateOrder($this->basket->model(), $this->basket->postage()->calculate(), 'stripe', ['token' => '123abc']));
    }

    /** @test */
    public function itGeneratesAKey()
    {
        $this->dispatchOrder();

        $this->assertNotNull($this->order->fresh()->order_key);
    }

    /** @test */
    public function itCreatesThePaymentRecord()
    {
        $this->dispatchOrder();

        $this->assertNotNull($this->order->payment());
    }

    /** @test */
    public function itHasTheCorrectDataInThePaymentRecord()
    {
        $this->dispatchOrder();

        $this->assertEquals(100, $this->order->payment->subtotal);
        $this->assertEquals(0, $this->order->payment->discount);
        $this->assertEquals(150, $this->order->payment->postage);
        $this->assertEquals(250, $this->order->payment->total);
        $this->assertEquals(1, $this->order->payment->payment_type_id);
    }

    /** @test */
    public function itStoresTheDiscountAmmountWhenAnOrderIncludesADiscount()
    {
        $code = factory(ShopDiscountCode::class)->create([
            'code' => 'foo',
            'deduction' => 10,
        ]);

        Event::dispatch(new CreateOrder(
            $this->basket->model(),
            $this->basket->postage()->calculate(),
            'stripe',
            ['token' => '123abc'],
            $code
        ));

        $this->order->fresh();

        $this->assertEquals(10, $this->order->payment->discount);

        // 100 subtotal minus 10% discount plus 150 postage
        $this->assertEquals(240, $this->order->payment->total);
    }

    /** @test */
    public function itStoresARecordAgainstTheDiscountForTheOrder()
    {
        /** @var ShopDiscountCode $code */
        $code = factory(ShopDiscountCode::class)->create([
            'code' => 'foo',
            'deduction' => 10,
        ]);

        $this->assertEmpty($code->orders);

        Event::dispatch(new CreateOrder(
            $this->basket->model(),
            $this->basket->postage()->calculate(),
            'stripe',
            ['token' => '123abc'],
            $code
        ));

        $this->order->fresh();
        $code->fresh()->load('orders');

        $this->assertNotEmpty($code->orders()->get());
        $this->assertTrue($this->order->is($code->orders()->first()));
    }

    /** @test */
    public function itLinksToTheCorrectPaymentType()
    {
        $this->dispatchOrder();

        $this->assertEquals('Stripe', $this->order->payment->type->type);
    }

    /** @test */
    public function itHasAPaymentResponse()
    {
        $this->dispatchOrder();

        $this->assertNotNull($this->order->payment->response);
    }

    /** @test */
    public function itHasACorrectResponseBody()
    {
        $this->dispatchOrder();

        $response = json_decode($this->order->payment->response->response, true);

        $this->assertIsArray($response);
        $this->assertEquals(['token' => '123abc'], $response);
    }

    /** @test */
    public function itMarksTheOrderAsPaid()
    {
        $this->dispatchOrder();

        $this->assertEquals(ShopOrderState::STATE_PAID, $this->order->fresh()->state_id);
    }

    /** @test */
    public function itCreatesANotificationForTheCustomer()
    {
        $this->dispatchOrder();

        Notification::assertSentTo(
            $this->user,
            OrderCreatedNotification::class,
            function (OrderCreatedNotification $notification) {
                return $notification->order->is($this->order);
            }
        );
    }

    /** @test */
    public function itCreatesANotificationForAlly()
    {
        $this->dispatchOrder();

        Notification::assertSentTo(admin_user(), OrderCreatedNotification::class);
    }
}
