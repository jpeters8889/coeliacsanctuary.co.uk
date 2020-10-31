<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Coeliac\Modules\Shop\Models\ShopOrderItem;

$factory->define(ShopOrderItem::class, function (Faker $faker) {
    return [
        'quantity' => 1,
    ];
});
