<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Coeliac\Modules\Shop\Models\ShopCategory;

$factory->define(ShopCategory::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'description' => $faker->sentence,
        'slug' => $faker->slug,
        'meta_keywords' => $faker->sentence,
        'meta_description' => $faker->sentence,
    ];
});
