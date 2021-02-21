<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(\Coeliac\Modules\Member\Models\Scrapbook::class, function (Faker $faker) {
    return [
        'name' => 'My Scrapbook',
    ];
});
