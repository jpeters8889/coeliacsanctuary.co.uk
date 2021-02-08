<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\UserAddress;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopOrderState;
use Illuminate\Testing\TestResponse;
use Spatie\TestTime\TestTime;
use Tests\Abstracts\DashboardTest;
use Tests\Traits\Shop\MakesShopOrders;

class OrderDashboardTest extends DashboardTest
{
    use MakesShopOrders;

    protected function page(): string
    {
        return 'orders';
    }

    protected function mustBeVerified(): bool
    {
        return true;
    }

    /** @test */
    public function it_displays_an_error_message_if_the_user_hasnt_verified_their_email()
    {
        $this->user->update(['email_verified_at' => null]);

        $this->get('/member/dashboard/orders')
            ->assertSee('You need to verify your email address before you can view your order history');
    }

    /** @test */
    public function it_loads_the_order_list_endpoint()
    {
        $this->makeRequest()->assertStatus(200);
    }

    /** @test */
    public function it_returns_a_paginated_list_of_orders()
    {
        $this->makeRequest()->assertJsonFragment(['current_page' => 1]);
    }

    /** @test */
    public function it_returns_the_orders_in_the_correct_format()
    {
        $this->createFullOrder(['user_id' => $this->user->id]);

        $this->makeRequest()
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
    public function it_shows_the_correct_number_of_items()
    {
        /** @var ShopOrder $order */
        $order = $this->createFullOrder(['user_id' => $this->user->id]);

        $this->makeRequest()->assertJsonFragment(['number_of_items' => 1]);

        $order->items()->create([
            'product_id' => 1,
            'product_variant_id' => 1,
            'quantity' => 1,
            'product_title' => 'foo',
            'product_price' => 1,
        ]);

        $this->makeRequest()->assertJsonFragment(['number_of_items' => 2]);
    }

    /** @test */
    public function it_shows_the_correct_state()
    {
        /** @var ShopOrder $order */
        $order = $this->createFullOrder(['user_id' => $this->user->id]);

        $this->makeRequest()->assertJsonFragment(['state' => 'Order']);

        $order->markAs(ShopOrderState::STATE_SHIPPED);

        $this->makeRequest()->assertJsonFragment(['state' => 'Shipped']);
    }

    /** @test */
    public function it_shows_the_shipped_at_date()
    {
        /** @var ShopOrder $order */
        $order = $this->createFullOrder(['user_id' => $this->user->id]);

        $this->makeRequest()->assertJsonFragment(['shipped_at' => null]);

        $order->update(['shipped_at' => Carbon::now()]);

        $this->makeRequest()->assertJsonMissing(['shipped_at' => null]);
    }

    /** @test */
    public function it_doesnt_show_baskets_that_didnt_convert()
    {
        $this->createFullOrder(['user_id' => $this->user->id]);

        $response = $this->makeRequest()->json();

        $this->assertCount(1, $response['data']);

        $this->createBasket(['user_id' => $this->user->id]);

        $response = $this->makeRequest()->json();

        $this->assertCount(1, $response['data']);
    }

    /** @test */
    public function it_doesnt_show_orders_not_linked_to_the_account()
    {
        $myOrder = $this->createFullOrder(['user_id' => $this->user->id]);

        $secondUser = factory(User::class)->create();

        $otherOrder = $this->createFullOrder(['user_id' => $secondUser->id]);

        $this->makeRequest()
            ->assertJsonFragment(['reference' => $myOrder->order_key])
            ->assertJsonMissing(['reference' => $otherOrder->order_key]);
    }

    /** @test */
    public function it_errors_when_trying_to_load_an_order_detail_page_for_another_user()
    {
        $secondUser = factory(User::class)->create();

        $otherOrder = $this->createFullOrder(['user_id' => $secondUser->id]);

        $this->get("/api/member/dashboard/orders/{$otherOrder->order_key}")->assertStatus(403);
    }

    /** @test */
    public function it_loads_the_order_detail_page_for_the_correct_user()
    {
        /** @var ShopOrder $order */
        $order = $this->createFullOrder(['user_id' => $this->user->id]);

        $this->get("/api/member/dashboard/orders/{$order->order_key}")->assertStatus(200);
    }

    /** @test */
    public function it_returns_the_orders_data()
    {
        /** @var ShopOrder $order */
        $order = $this->createFullOrder(['user_id' => $this->user->id]);

        $response = $this->makeOrderInfoRequest($order)->json();

        $keys = ['order_date', 'reference', 'number_of_items', 'state', 'shipped_at', 'address', 'items', 'payment'];

        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $response);
        }
    }

    /** @test */
    public function it_returns_the_correct_shipping_address()
    {
        /** @var ShopOrder $order */
        $order = $this->createFullOrder(['user_id' => $this->user->id]);

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
    public function it_returns_an_array_of_items()
    {
        /** @var ShopOrder $order */
        $order = $this->createFullOrder(['user_id' => $this->user->id]);

        $request = $this->makeOrderInfoRequest($order)->json();

        $this->assertIsArray($request['items']);
    }

    /** @test */
    public function it_returns_the_items_in_the_correct_format()
    {
        /** @var ShopOrder $order */
        $order = $this->createFullOrder(['user_id' => $this->user->id]);

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
    public function it_returns_the_payment_information()
    {
        /** @var ShopOrder $order */
        $order = $this->createFullOrder(['user_id' => $this->user->id]);

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
