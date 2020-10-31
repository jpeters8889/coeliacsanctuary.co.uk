<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Coeliac\Modules\Shop\Models\ShopProductVariant;

$factory->define(ShopProductVariant::class, function (Faker $faker) {
    return [
        'title' => $faker->words(3, true),
        'weight' => $faker->numberBetween(1, 20),
        'quantity' => $faker->numberBetween(1, 500),
    ];
});
