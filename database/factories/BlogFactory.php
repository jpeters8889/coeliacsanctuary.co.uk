<?php

declare(strict_types=1);

use Faker\Generator as Faker;

$factory->define(Coeliac\Modules\Blog\Models\Blog::class, function (Faker $faker) {
    $title = $faker->sentence;

    return [
        'title' => $title,
        'slug' => \Illuminate\Support\Str::slug($title),
        'description' => $faker->paragraph,
        'body' => $faker->paragraph,
        'live' => true,
        'meta_tags' => $faker->paragraph,
        'meta_description' => $faker->paragraph,
    ];
});
