<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Shop\Postage;

use Coeliac\Modules\Shop\Models\ShopPostageCountry;
use Coeliac\Modules\Shop\Models\ShopPostageCountryArea;
use Coeliac\Modules\Shop\Models\ShopPostagePrice;
use Tests\TestCase;

class ShopPostageCountryAreaTest extends TestCase
{
    /** @test */
    public function itHasManyCountries()
    {
        $area = ShopPostageCountryArea::query()->first();

        $this->assertNotNull($area->countries);
        $this->assertInstanceOf(ShopPostageCountry::class, $area->countries()->first());
    }

    /** @test */
    public function itHasManyPrices()
    {
        $area = ShopPostageCountryArea::query()->first();

        $this->assertNotNull($area->postagePrices);
        $this->assertInstanceOf(ShopPostagePrice::class, $area->postagePrices()->first());
    }
}
