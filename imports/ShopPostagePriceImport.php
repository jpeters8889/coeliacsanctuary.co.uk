<?php

declare(strict_types=1);

namespace Imports;

use Coeliac\Modules\Shop\Models\ShopPostagePrice;

class ShopPostagePriceImport extends Import
{
    public function handle()
    {
        $seeds = $this->shopDatabase->table('postage')->get();

        $countries = [
            'United Kingdom' => 1,
            'EU' => 2,
            'NA' => 3,
            'OZ' => 4,
        ];

        $shippingMethods = [
            'small' => 1,
            'large' => 3,
            'smallParcel' => 4,
        ];

        $bar = $this->command->makeProgressBar(count($seeds));
        $bar->start();

        foreach ($seeds as $seed) {
            ShopPostagePrice::query()->insert([
                'postage_country_area_id' => $countries[$seed->country],
                'shipping_method_id' => $shippingMethods[$seed->shipAs],
                'max_weight' => $seed->maxWeight,
                'price' => $seed->price * 100,
                'created_at' => $seed->created_at,
                'updated_at' => $seed->updated_at,
            ]);

            $bar->advance();
        }

        $bar->finish();
    }
}
