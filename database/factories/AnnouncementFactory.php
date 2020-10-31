<?php

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Carbon\Carbon;
use Faker\Generator as Faker;
use Coeliac\Common\Models\Announcement;

$factory->define(Announcement::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(),
        'text' => $faker->paragraph,
        'live' => true,
        'expires_at' => Carbon::now()->addDay(),
    ];
});
