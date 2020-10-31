<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Coeliac\Modules\Shop\Models\ShopPaymentType;

$factory->define(ShopPaymentType::class, function (Faker $faker) {
    return [
        'type' => 'Stripe',
    ];
});
