<?php

declare(strict_types=1);

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Coeliac\Modules\EatingOut\Reviews\Models\Review;

$factory->define(Review::class, function (Faker $faker) {
    return [
        'title' => $title = $faker->sentence,
        'slug' => $slug = Str::slug($title),
        'legacy_slug' => $slug,
        'body' => $faker->paragraph,
        'overall_rating' => $faker->numberBetween(1, 5),
        'knowledge_rating' => $faker->numberBetween(1, 5),
        'presentation_taste_rating' => $faker->numberBetween(1, 5),
        'value_rating' => $faker->numberBetween(1, 5),
        'general_rating' => $faker->numberBetween(1, 5),
        'live' => true,
        'meta_tags' => $faker->paragraph,
        'meta_description' => $faker->paragraph,
    ];
});
