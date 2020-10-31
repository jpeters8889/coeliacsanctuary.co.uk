<?php

declare(strict_types=1);

use Faker\Generator as Faker;

$factory->define(\Coeliac\Common\Models\Accordion::class, function (Faker $faker) {
    return [
        'accordion_type_id' => $faker->randomElement([1, 2]),
        'title' => $faker->name,
        'body' => $faker->paragraph,
    ];
});
