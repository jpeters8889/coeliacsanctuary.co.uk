<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Shop\Postage;

use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopPostageCountry;
use Coeliac\Modules\Shop\Models\ShopPostageCountryArea;
use Tests\TestCase;

class ShopPostageCountryTest extends TestCase
{
    /** @test */
    public function itBelongsToAnArea()
    {
        $country = ShopPostageCountry::query()->first();

        $this->assertNotNull($country->area);
        $this->assertInstanceOf(ShopPostageCountryArea::class, $country->area);
    }

    /** @test */
    public function itHasManyOrders()
    {
        $this->create(ShopOrder::class);

        $countries = ShopPostageCountry::query()->first();

        $this->assertNotNull($countries->orders);
        $this->assertInstanceOf(ShopOrder::class, $countries->orders()->first());

        $this->assertEquals(ShopOrder::query()->first()->toArray(), $countries->orders()->first()->toArray());
    }
}
