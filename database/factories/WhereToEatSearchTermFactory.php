<?php

declare(strict_types=1);

use Faker\Generator as Faker;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatSearchTerm;

$factory->define(WhereToEatSearchTerm::class, function (Faker $faker) {
    return [
        'term' => $faker->word,
        'range' => $faker->randomElement(['1', '2', '5', '10', '20']),
    ];
});
