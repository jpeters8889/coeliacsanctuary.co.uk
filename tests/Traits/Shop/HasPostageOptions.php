<?php

declare(strict_types=1);

namespace Tests\Traits\Shop;

use Coeliac\Modules\Shop\Models\ShopPostagePrice;
use Coeliac\Modules\Shop\Models\ShopPostageCountry;
use Coeliac\Modules\Shop\Models\ShopShippingMethod;
use Coeliac\Modules\Shop\Models\ShopPostageCountryArea;

trait HasPostageOptions
{
    protected function setupPostage()
    {
        factory(ShopPostageCountryArea::class)->create([
            'area' => 'United Kingdom',
            'delivery_timescale' => '1 - 2',
        ]);

        factory(ShopPostageCountryArea::class)->create([
            'area' => 'Europe',
            'delivery_timescale' => '3 - 5',
        ]);

        factory(ShopPostageCountry::class)->create([
            'postage_area_id' => 1,
            'country' => 'United Kingdom',
            'iso_code' => 'GB',
        ]);

        factory(ShopPostageCountry::class)->create([
            'postage_area_id' => 2,
            'country' => 'Republic of Ireland',
            'iso_code' => 'IE',
        ]);

        factory(ShopShippingMethod::class)->create(['shipping_method' => 'letter']);
        factory(ShopShippingMethod::class)->create(['shipping_method' => 'parcel']);

        factory(ShopPostagePrice::class)->create([
            'postage_country_area_id' => 1,
            'shipping_method_id' => 1,
            'max_weight' => 100,
            'price' => 150,
        ]);

        factory(ShopPostagePrice::class)->create([
            'postage_country_area_id' => 1,
            'shipping_method_id' => 1,
            'max_weight' => 200,
            'price' => 250,
        ]);

        factory(ShopPostagePrice::class)->create([
            'postage_country_area_id' => 2,
            'shipping_method_id' => 1,
            'max_weight' => 100,
            'price' => 300,
        ]);
    }
}
