<?php

declare(strict_types=1);

use Faker\Generator as Faker;

$factory->define(\Coeliac\Modules\Recipe\Models\RecipeNutrition::class, function (Faker $faker) {
    return [
        'calories' => $faker->randomDigitNotNull,
        'carbs' => $faker->randomDigitNotNull,
        'fat' => $faker->randomDigitNotNull,
        'protein' => $faker->randomDigitNotNull,
        'fibre' => $faker->randomDigitNotNull,
        'sugar' => $faker->randomDigitNotNull,
    ];
});
