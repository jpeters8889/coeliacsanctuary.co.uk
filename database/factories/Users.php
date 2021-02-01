<?php

declare(strict_types=1);

/** @var Factory $factory */

use Carbon\Carbon;
use Faker\Generator as Faker;
use Coeliac\Modules\Member\Models\User;
use Illuminate\Database\Eloquent\Factory;
use Coeliac\Modules\Member\Models\UserLevel;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'email_verified_at' => Carbon::now(),
        'phone' => $faker->phoneNumber,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
        'user_level_id' => UserLevel::SHOP,
    ];
});
