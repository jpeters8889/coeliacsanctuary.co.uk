<?php

declare(strict_types=1);

use Faker\Generator as Faker;

$factory->define(\Coeliac\Common\Models\Image::class, function (Faker $faker) {
    return [
        'file_name' => \Illuminate\Support\Str::random(),
        'directory' => '',
    ];
});
