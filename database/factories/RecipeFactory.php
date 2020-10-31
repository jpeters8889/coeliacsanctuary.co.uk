<?php

declare(strict_types=1);

use Faker\Generator as Faker;

$factory->define(\Coeliac\Modules\Recipe\Models\Recipe::class, function (Faker $faker) {
    $title = $faker->sentence;

    return [
        'title' => $title,
        'slug' => \Illuminate\Support\Str::slug($title),
        'meta_tags' => $faker->paragraph,
        'meta_description' => $faker->paragraph,
        'description' => $faker->paragraph,
        'ingredients' => $faker->text,
        'method' => $faker->paragraphs(5, true),
        'author' => $faker->name,
        'serving_size' => '8 Slices',
        'per' => 'slice',
        'search_tags' => $faker->words(5, true),
        'df_to_not_df' => '',
        'prep_time' => '1 Hour',
        'cook_time' => '1 Hour',
        'live' => true,
    ];
});
