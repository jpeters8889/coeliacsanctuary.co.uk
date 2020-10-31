<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(\Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatRating::class, function (Faker $faker) {
    return [
        'rating' => $faker->numberBetween(1, 5),
        'ip' => $faker->ipv6,
        'name' => $faker->name,
        'email' => $faker->email,
        'body' => $faker->paragraph,
        'method' => 'test',
        'approved' => false,
    ];
});
