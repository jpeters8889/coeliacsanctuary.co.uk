<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Carbon\Carbon;
use Faker\Generator as Faker;
use Coeliac\Modules\Shop\Models\ShopMassDiscount;

$factory->define(ShopMassDiscount::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'percentage' => random_int(5, 50),
        'start_at' => Carbon::now(),
        'end_at' => Carbon::now()->addDay(),
        'created' => false,
    ];
});
