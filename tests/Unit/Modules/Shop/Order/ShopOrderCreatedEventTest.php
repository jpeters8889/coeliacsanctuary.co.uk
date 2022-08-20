<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Shop\Order;

use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\UserAddress;
use Coeliac\Modules\Shop\Basket\Basket;
use Coeliac\Modules\Shop\Events\CreateOrder;
use Coeliac\Modules\Shop\Models\ShopDiscountCode;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopOrderItem;
use Coeliac\Modules\Shop\Models\ShopOrderState;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Coeliac\Modules\Shop\Models\ShopProductVariant;
use Coeliac\Modules\Shop\Notifications\OrderCreatedNotification;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ShopOrderCreatedEventTest extends TestCase
{
    private Basket $basket;

    private ShopOrder $order;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        Notification::fake();

        $this->user = $this->build(User::class)
            ->has($this->build(UserAddress::class)->asShipping(), 'addresses')
            ->create();

        $this->order = $this->build(ShopOrder::class)
            ->asBasket()
            ->to($this->user)
            ->create();

        $this->build(ShopOrderItem::class)
            ->to($this->order)
            ->add($this->build(ShopProductVariant::class)
            ->in($this->build(ShopProduct::class)
            ->has($this->build(ShopProductPrice::class)->state(['price' => 100]), 'prices')
            ->create())
            ->create(['weight' => 10]))
            ->create();

        $this->app->make(Store::class)->push('basket_token', $this->order->token);

        $this->basket = new Basket($this->app->make(Store::class));

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
        Event::dispatch(new CreateOrder(
            $this->basket->model(),
            $this->basket->postage()->calculate(),
            'stripe',
            ['token' => '123abc'],
            $this->create(ShopDiscountCode::class)
        ));

        $this->order->fresh();

        $this->assertEquals(10, $this->order->payment->discount);

        // 100 subtotal minus 10% discount plus 150 postage
        $this->assertEquals(240, $this->order->payment->total);
    }

    /** @test */
    public function itStoresARecordAgainstTheDiscountForTheOrder()
    {
        $code = $this->create(ShopDiscountCode::class);

        $this->assertEmpty($code->orders);

        Event::dispatch(new CreateOrder(
            $this->basket->model(),
            $this->basket->postage()->calculate(),
            'stripe',
            ['token' => '123abc'],
            $code,
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
