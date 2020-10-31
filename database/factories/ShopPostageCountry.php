<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Coeliac\Modules\Shop\Models\ShopPostageCountry;

$factory->define(ShopPostageCountry::class, function (Faker $faker) {
    return [
//        'shipping_method' => $faker->word,
    ];
});
