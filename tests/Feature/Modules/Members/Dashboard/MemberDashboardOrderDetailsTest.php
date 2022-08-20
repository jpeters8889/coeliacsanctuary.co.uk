<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Members\Dashboard;

use Carbon\Carbon;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\UserAddress;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopOrderItem;
use Coeliac\Modules\Shop\Models\ShopOrderState;
use Coeliac\Modules\Shop\Models\ShopPayment;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Coeliac\Modules\Shop\Models\ShopProductVariant;
use Illuminate\Testing\TestResponse;
use Tests\Abstracts\DashboardTest;

class MemberDashboardOrderDetailsTest extends DashboardTest
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->build(UserAddress::class)
            ->asShipping()
            ->to($this->user)
            ->create();
    }

    protected function page(): string
    {
        return 'orders';
    }

    protected function mustBeVerified(): bool
    {
        return true;
    }

    /** @test */
    public function itDisplaysAnErrorMessageIfTheUserHasntVerifiedTheirEmail()
    {
        $this->user->update(['email_verified_at' => null]);

        $this->get('/member/dashboard/orders')
            ->assertSee('You need to verify your email address before you can view your order history');
    }

    /** @test */
    public function itLoadsTheOrderListEndpoint()
    {
        $this->makeRequest()->assertStatus(200);
    }

    /** @test */
    public function itReturnsAPaginatedListOfOrders()
    {
        $this->makeApiRequest()->assertJsonFragment(['current_page' => 1]);
    }

    /** @test */
    public function itReturnsTheOrdersInTheCorrectFormat()
    {
        $this->build(ShopOrder::class)
            ->to($this->user)
            ->asPaid()
            ->has($this->build(ShopPayment::class), 'payment')
            ->create();

        $this->makeApiRequest()
            ->assertJsonStructure([
                'data' => [[
                    'order_date',
                    'reference',
                    'number_of_items',
                    'state',
                    'shipped_at',
                ]],
            ]);
    }

    /** @test */
    public function itShowsTheCorrectNumberOfItems()
    {
        $order = $this->build(ShopOrder::class)
            ->to($this->user)
            ->asPaid()
            ->has($this->build(ShopPayment::class), 'payment')
            ->create();

        $this->build(ShopOrderItem::class)
            ->to($order)
            ->add($this->build(ShopProductVariant::class)
            ->in($this->build(ShopProduct::class)
            ->has($this->build(ShopProductPrice::class)->state(['price' => 100]), 'prices')
            ->create())
            ->create(['weight' => 10]))
            ->create();

        $this->makeApiRequest()->assertJsonFragment(['number_of_items' => 1]);

        $order->items()->create([
            'product_id' => 1,
            'product_variant_id' => 1,
            'quantity' => 1,
            'product_title' => 'foo',
            'product_price' => 1,
        ]);

        $this->makeApiRequest()->assertJsonFragment(['number_of_items' => 2]);
    }

    /** @test */
    public function itShowsTheCorrectState()
    {
        $order = $this->build(ShopOrder::class)
            ->to($this->user)
            ->asPaid()
            ->has($this->build(ShopPayment::class), 'payment')
            ->create();

        $this->makeApiRequest()->assertJsonFragment(['state' => 'Order']);

        $order->markAs(ShopOrderState::STATE_SHIPPED);

        $this->makeApiRequest()->assertJsonFragment(['state' => 'Shipped']);
    }

    /** @test */
    public function itShowsTheShippedAtDate()
    {
        $order = $this->build(ShopOrder::class)
            ->to($this->user)
            ->asPaid()
            ->has($this->build(ShopPayment::class), 'payment')
            ->create();

        $this->makeApiRequest()->assertJsonFragment(['shipped_at' => null]);

        $order->update(['shipped_at' => Carbon::now()]);

        $this->makeApiRequest()->assertJsonMissing(['shipped_at' => null]);
    }

    /** @test */
    public function itDoesntShowBasketsThatDidntConvert()
    {
        $this->build(ShopOrder::class)
            ->to($this->user)
            ->asPaid()
            ->has($this->build(ShopPayment::class), 'payment')
            ->create();

        $response = $this->makeApiRequest()->json();

        $this->assertCount(1, $response['data']);

        $this->build(ShopOrder::class)
            ->asBasket()
            ->to($this->user)
            ->create();

        $response = $this->makeApiRequest()->json();

        $this->assertCount(1, $response['data']);
    }

    /** @test */
    public function itDoesntShowOrdersNotLinkedToTheAccount()
    {
        $myOrder = $this->build(ShopOrder::class)
            ->to($this->user)
            ->asPaid()
            ->has($this->build(ShopPayment::class), 'payment')
            ->create();

        $otherOrder = $this->build(ShopOrder::class)
            ->to($this->build(User::class)->has($this->build(UserAddress::class)->asShipping(), 'addresses')->create())
            ->asPaid()
            ->has($this->build(ShopPayment::class), 'payment')
            ->create();

        $this->makeApiRequest()
            ->assertJsonFragment(['reference' => $myOrder->order_key])
            ->assertJsonMissing(['reference' => $otherOrder->order_key]);
    }

    /** @test */
    public function itErrorsWhenTryingToLoadAnOrderDetailPageForAnotherUser()
    {
        $otherOrder = $this->build(ShopOrder::class)
            ->to($this->build(User::class)->has($this->build(UserAddress::class)->asShipping(), 'addresses')->create())
            ->asPaid()
            ->has($this->build(ShopPayment::class), 'payment')
            ->create();

        $this->get("/api/member/dashboard/orders/{$otherOrder->order_key}")->assertStatus(403);
    }

    /** @test */
    public function itLoadsTheOrderDetailPageForTheCorrectUser()
    {
        /** @var ShopOrder $order */
        $order = $this->build(ShopOrder::class)
            ->to($this->user)
            ->asPaid()
            ->has($this->build(ShopPayment::class), 'payment')
            ->create();

        $this->get("/api/member/dashboard/orders/{$order->order_key}")->assertStatus(200);
    }

    /** @test */
    public function itReturnsTheOrdersData()
    {
        /** @var ShopOrder $order */
        $order = $this->build(ShopOrder::class)
            ->to($this->user)
            ->asPaid()
            ->has($this->build(ShopPayment::class), 'payment')
            ->create();

        $response = $this->makeOrderInfoRequest($order)->json();

        $keys = ['order_date', 'reference', 'number_of_items', 'state', 'shipped_at', 'address', 'items', 'payment'];

        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $response);
        }
    }

    /** @test */
    public function itReturnsTheCorrectShippingAddress()
    {
        /** @var ShopOrder $order */
        $order = $this->build(ShopOrder::class)
            ->to($this->user)
            ->asPaid()
            ->has($this->build(ShopPayment::class), 'payment')
            ->create();

        $order->address->update($params = [
            'line_1' => 'First Line',
            'line_2' => 'Second Line',
            'line_3' => 'Third Line',
            'town' => 'My Town',
            'postcode' => 'AB1 2CD',
            'country' => 'England',
        ]);

        $request = $this->makeOrderInfoRequest($order)->json();

        foreach ($params as $key => $value) {
            $this->assertArrayHasKey($key, $request['address']);
            $this->assertEquals($value, $request['address'][$key]);
        }
    }

    /** @test */
    public function itReturnsAnArrayOfItems()
    {
        /** @var ShopOrder $order */
        $order = $this->build(ShopOrder::class)
            ->to($this->user)
            ->asPaid()
            ->has($this->build(ShopPayment::class), 'payment')
            ->create();

        $request = $this->makeOrderInfoRequest($order)->json();

        $this->assertIsArray($request['items']);
    }

    /** @test */
    public function itReturnsTheItemsInTheCorrectFormat()
    {
        /** @var ShopOrder $order */
        $order = $this->build(ShopOrder::class)
            ->to($this->user)
            ->asPaid()
            ->has($this->build(ShopPayment::class), 'payment')
            ->create();

        $this->build(ShopOrderItem::class)
            ->to($order)
            ->add($this->build(ShopProductVariant::class)
            ->in($this->build(ShopProduct::class)
            ->has($this->build(ShopProductPrice::class)->state(['price' => 100]), 'prices')
            ->create())
            ->create(['weight' => 10]))
            ->create();

        $request = $this->makeOrderInfoRequest($order)->json();

        $keys = ['quantity', 'product_title', 'product_price', 'subtotal'];

        foreach ($request['items'] as $index => $item) {
            foreach ($keys as $key) {
                $this->assertArrayHasKey($key, $item);
                $this->assertEquals($item[$key], $order->items[$index]->$key);
            }
        }
    }

    /** @test */
    public function itReturnsThePaymentInformation()
    {
        /** @var ShopOrder $order */
        $order = $this->build(ShopOrder::class)
            ->to($this->user)
            ->asPaid()
            ->has($this->build(ShopPayment::class), 'payment')
            ->create();

        $request = $this->makeOrderInfoRequest($order)->json();

        $keys = ['subtotal', 'discount', 'postage', 'total', 'payment_type'];

        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $request['payment']);
            $this->assertEquals($request['payment'][$key], $order->payment->$key);
        }
    }

    protected function makeOrderInfoRequest(ShopOrder $order): TestResponse
    {
        return $this->get("/api/member/dashboard/orders/{$order->order_key}");
    }
}
