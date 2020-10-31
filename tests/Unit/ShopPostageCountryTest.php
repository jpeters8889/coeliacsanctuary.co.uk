<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;
use Tests\Traits\Shop\MakesShopOrders;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\Shop\Models\ShopPostageCountry;
use Coeliac\Modules\Shop\Models\ShopPostageCountryArea;

class ShopPostageCountryTest extends TestCase
{
    use RefreshDatabase;
    use MakesShopOrders;

    /** @test */
    public function it_belongs_to_an_area()
    {
        $country = ShopPostageCountry::query()->first();

        $this->assertNotNull($country->area);
        $this->assertInstanceOf(ShopPostageCountryArea::class, $country->area);
    }

    /** @test */
    public function it_has_many_orders()
    {
        $this->createOrder();

        $countries = ShopPostageCountry::query()->first();

        $this->assertNotNull($countries->orders);
        $this->assertInstanceOf(ShopOrder::class, $countries->orders()->first());

        $this->assertEquals(ShopOrder::query()->first()->toArray(), $countries->orders()->first()->toArray());
    }
}
