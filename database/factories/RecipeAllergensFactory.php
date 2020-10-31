<?php

declare(strict_types=1);

use Faker\Generator as Faker;

$factory->define(\Coeliac\Modules\Recipe\Models\RecipeAllergen::class, function (Faker $faker) {
    return [
        'allergen' => $faker->word,
    ];
});
