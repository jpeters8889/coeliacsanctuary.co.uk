<?php

declare(strict_types=1);

use Faker\Generator as Faker;

$factory->define(\Coeliac\Modules\Recipe\Models\RecipeMeal::class, function (Faker $faker) {
    return [
        'meal' => $faker->word,
    ];
});
