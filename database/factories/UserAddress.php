<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Coeliac\Modules\Member\Models\UserAddress;

$factory->define(UserAddress::class, function (Faker $faker) {
    return [
        'type' => $faker->randomElement(['Shipping', 'Billing']),
        'name' => $faker->name,
        'line_1' => $faker->buildingNumber,
        'line_2' => $faker->streetAddress,
        'town' => $faker->city,
        'postcode' => $faker->postcode,
        'country' => 'England',
    ];
});
