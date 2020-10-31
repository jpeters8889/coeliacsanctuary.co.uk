<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Coeliac\Modules\Shop\Models\ShopPaymentResponse;

$factory->define(ShopPaymentResponse::class, function (Faker $faker) {
    return [
        'response' => $faker->paragraphs(3, true),
    ];
});
