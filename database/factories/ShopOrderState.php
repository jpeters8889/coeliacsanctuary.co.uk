<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Coeliac\Modules\Shop\Models\ShopOrderState;

$factory->define(ShopOrderState::class, function (Faker $faker) {
    return [
        'state' => 'Basket',
    ];
});
