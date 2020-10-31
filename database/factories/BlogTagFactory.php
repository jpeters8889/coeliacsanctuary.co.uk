<?php

declare(strict_types=1);

use Faker\Generator as Faker;

$factory->define(\Coeliac\Modules\Blog\Models\BlogTag::class, function (Faker $faker) {
    return [
        'tag' => $faker->word,
        'slug' => $faker->word,
    ];
});
