<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Coeliac\Modules\Shop\Models\ShopProductPrice;

$factory->define(ShopProductPrice::class, function (Faker $faker) {
    return [
        'price' => $faker->numberBetween(100, 1500),
    ];
});
