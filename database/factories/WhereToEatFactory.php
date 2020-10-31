<?php

declare(strict_types=1);

use Faker\Generator as Faker;

$factory->define(\Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat::class, function (Faker $faker) {
    return [
        'name' => $faker->title,
        'info' => $faker->sentence,
        'address' => str_replace(', ', '<br />', $faker->address),
        'phone' => $faker->phoneNumber,
        'website' => $faker->url,
        'lat' => $faker->latitude,
        'lng' => $faker->longitude,
        'live' => true,
    ];
});
