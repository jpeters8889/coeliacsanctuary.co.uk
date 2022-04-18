<?php

declare(strict_types=1);

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCountry;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCuisine;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatTown;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatType;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatVenueType;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Shop\Models\ShopOrderState;
use Coeliac\Modules\Shop\Models\ShopPaymentType;
use Coeliac\Modules\Shop\Models\ShopPostageCountry;
use Coeliac\Modules\Shop\Models\ShopPostageCountryArea;
use Coeliac\Modules\Shop\Models\ShopPostagePrice;
use Coeliac\Modules\Shop\Models\ShopShippingMethod;
use Database\Factories\Factory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        Factory::factoryForModel(User::class)
            ->asAdmin()
            ->create(['email' => 'contact@coeliacsanctuary.co.uk']);

        $modelsToCreate = [
            WhereToEatCountry::class,
            WhereToEatCounty::class,
            WhereToEatTown::class,
            WhereToEatType::class,
            WhereToEatVenueType::class,
            WhereToEatCuisine::class,
        ];

        foreach ($modelsToCreate as $model) {
            Factory::factoryForModel($model)->create();
        }

        ShopOrderState::query()
            ->insert([
                ['state' => 'Basket'],
                ['state' => 'Order'],
                ['state' => 'Processing'],
                ['state' => 'Shipped'],
                ['state' => 'Complete'],
                ['state' => 'Refund'],
                ['state' => 'Cancelled'],
            ]);

        ShopPaymentType::query()
            ->insert([
                ['type' => 'Stripe'],
                ['type' => 'PayPal'],
            ]);

        ShopPostageCountryArea::query()
            ->insert([
                [
                    'area' => 'United Kingdom',
                    'delivery_timescale' => '1 - 2',
                ],
                [
                    'area' => 'Europe',
                    'delivery_timescale' => '3 - 5',
                ],
            ]);

        ShopPostageCountry::query()
            ->insert([
                [
                    'postage_area_id' => 1,
                    'country' => 'United Kingdom',
                    'iso_code' => 'GB',
                ],
                [
                    'postage_area_id' => 2,
                    'country' => 'Republic of Ireland',
                    'iso_code' => 'IE',
                ],
            ]);

        ShopShippingMethod::query()
            ->insert([
                ['shipping_method' => 'letter'],
                ['shipping_method' => 'parcel'],
            ]);

        ShopPostagePrice::query()
            ->insert([
                [
                    'postage_country_area_id' => 1,
                    'shipping_method_id' => 1,
                    'max_weight' => 100,
                    'price' => 150,
                ],
                [
                    'postage_country_area_id' => 1,
                    'shipping_method_id' => 1,
                    'max_weight' => 200,
                    'price' => 250,
                ],
                [
                    'postage_country_area_id' => 2,
                    'shipping_method_id' => 1,
                    'max_weight' => 100,
                    'price' => 300,
                ],
            ]);
    }
}
