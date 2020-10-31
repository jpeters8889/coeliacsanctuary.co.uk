<?php

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Coeliac\Modules\EatingOut\WhereToEat\Models\PlaceRequest;

$factory->define(PlaceRequest::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'addOrRemove' => $faker->randomElement(['add', 'remove']),
        'details' => $faker->paragraph,
        'completed' => 0,
    ];
});
