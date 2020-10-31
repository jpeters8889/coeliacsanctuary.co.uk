<?php

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Coeliac\Common\Models\Popup;

$factory->define(Popup::class, function (Faker $faker) {
    return [
        'text' => $faker->paragraph,
        'link' => $faker->url,
        'display_every' => random_int(1, 7),
        'live' => true,
    ];
});
