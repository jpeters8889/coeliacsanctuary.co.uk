<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Session\Store;
use Coeliac\Modules\Shop\Basket\Basket;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShopBasketTest extends TestCase
{
    use RefreshDatabase;

    private Store $session;
    private Basket $basket;

    protected function setUp(): void
    {
        parent::setUp();

        $this->session = resolve(Store::class);
        $this->basket = resolve(Basket::class);
    }

    /** @test */
    public function it_creates_a_basket()
    {
        $this->assertFalse($this->session->has('basket_token'));
        $this->assertEmpty(ShopOrder::query()->get());

        $this->basket->create();

        $this->assertTrue($this->session->has('basket_token'));
        $this->assertNotEmpty(ShopOrder::query()->get());

        /** @var ShopOrder $shopOrder */
        $shopOrder = ShopOrder::query()->first();

        $this->assertEmpty($shopOrder->items);
        $this->assertEquals($shopOrder->token, $this->session->get('basket_token'));
    }

    /** @test */
    public function it_returns_the_model_instance()
    {
        $this->basket->create();

        /** @var ShopOrder $shopOrder */
        $shopOrder = ShopOrder::query()->first();

        $this->assertInstanceOf(ShopOrder::class, $this->basket->model());
        $this->assertTrue($shopOrder->is($this->basket->model()));
    }

    /** @test */
    public function it_resolves_an_already_existing_basket()
    {
        $this->assertFalse($this->basket->resolve());

        $shopOrder = ShopOrder::query()->create(['token' => 'foo']);
        $this->withSession(['basket_token' => 'foo']);

        $this->assertTrue($this->basket->resolve());

        $this->assertInstanceOf(ShopOrder::class, $this->basket->model());
        $this->assertTrue($shopOrder->is($this->basket->model()));
    }
}
