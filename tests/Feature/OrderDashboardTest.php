<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\UserAddress;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopOrderState;
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
    public function it_loads_the_order_list_endpoint()
    {
        $this->get('/api/member/dashboard/orders')->assertStatus(200);
    }

    /** @test */
    public function it_returns_a_paginated_list_of_orders()
    {
        $this->get('/api/member/dashboard/orders')->assertJsonFragment(['current_page' => 1]);
    }

    /** @test */
    public function it_returns_the_orders_in_the_correct_format()
    {
        $this->createFullOrder(['user_id' => $this->user->id]);

        $this->get('/api/member/dashboard/orders')
            ->assertJsonStructure([
                'data' => [[
                    'order_date',
                    'reference',
                    'number_of_items',
                    'state',
                    'shipping_address',
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
    public function it_shows_the_users_address()
    {
        $this->createFullOrder(['user_id' => $this->user->id]);

        $keys = ['name', 'line_1', 'line_2', 'line_3', 'town', 'postcode', 'county'];

        $request = $this->makeRequest()->json();

        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $request['data'][0]['shipping_address']);
        }
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
//    public function it_doesnt_show_baskets_that_didnt_convert()
//    {
//        //
//    }
//
//    /** @test */
//    public function it_shows_the_users_orders()
//    {
//        $firstOrder = $this->createOrder(['user_id' => $this->user->id]);
//        $secondOrder = $this->createOrder(['user_id' => $this->user->id]);
//
//        $this->get('/api/member/dashboard/orders')
//            ->assertJsonFragment(['order_key']);
//    }
//
//    /** @test */
//    public function it_doesnt_show_orders_not_linked_to_the_account()
//    {
//        $secondUser = factory(User::class)->create();
//
//        $order = $this->createOrder(['user_id' => $secondUser->id]);
//
//        $this->get('/api/members/dashboard/orders')->assertJsonMissing(['reference' => $order->order_key]);
//    }
}
