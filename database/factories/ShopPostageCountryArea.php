<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Coeliac\Modules\Shop\Models\ShopPostageCountryArea;

$factory->define(ShopPostageCountryArea::class, function (Faker $faker) {
    return [
//        'area' => $faker->country,
    ];
});
