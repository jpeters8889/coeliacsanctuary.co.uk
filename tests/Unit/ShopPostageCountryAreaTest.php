<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;
use Tests\Traits\Shop\MakesShopOrders;
use Coeliac\Modules\Shop\Models\ShopPostagePrice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\Shop\Models\ShopPostageCountry;
use Coeliac\Modules\Shop\Models\ShopPostageCountryArea;

class ShopPostageCountryAreaTest extends TestCase
{
    use RefreshDatabase;
    use MakesShopOrders;

    /** @test */
    public function it_has_many_countries()
    {
        $area = ShopPostageCountryArea::query()->first();

        $this->assertNotNull($area->countries);
        $this->assertInstanceOf(ShopPostageCountry::class, $area->countries()->first());
    }

    /** @test */
    public function it_has_many_prices()
    {
        $area = ShopPostageCountryArea::query()->first();

        $this->assertNotNull($area->postagePrices);
        $this->assertInstanceOf(ShopPostagePrice::class, $area->postagePrices()->first());
    }
}
