<?php

declare(strict_types=1);

use Faker\Generator as Faker;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatTown;

$factory->define(WhereToEatTown::class, function (Faker $faker) {
    $town = $faker->city;

    return [
        'town' => $town,
        'slug' => \Illuminate\Support\Str::slug($town),
        'legacy' => \Illuminate\Support\Str::slug($town),
    ];
});
