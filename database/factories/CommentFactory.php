<?php

declare(strict_types=1);

use Faker\Generator as Faker;

$factory->define(\Coeliac\Common\Models\Comment::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'comment' => $faker->paragraph,
    ];
});
