<?php

declare(strict_types=1);

use Faker\Generator as Faker;

$factory->define(\Coeliac\Modules\Collection\Models\Collection::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'meta_keywords' => implode(',', $faker->words(5)),
        'meta_description' => $description = $faker->paragraph,
        'long_description' => $description,
        'body' => $faker->paragraphs(3, true),
    ];
});
