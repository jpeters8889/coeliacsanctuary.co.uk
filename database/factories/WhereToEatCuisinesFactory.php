<?php

declare(strict_types=1);

use Faker\Generator as Faker;

$factory->define(\Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCuisine::class, function (Faker $faker) {
    return [
        'cuisine' => $faker->name,
    ];
});
