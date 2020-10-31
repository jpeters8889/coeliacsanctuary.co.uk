<?php

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Coeliac\Modules\Shop\Models\ShopDiscountCode;

$factory->define(ShopDiscountCode::class, function (Faker $faker) {
    return [
        'name' => $name = $faker->sentence,
        'code' => \Illuminate\Support\Str::slug($name),
        'start_at' => $now = \Carbon\Carbon::now(),
        'end_at' => $now->addWeek(),
        'min_spend' => 1,
        'deduction' => 10,
    ];
});
