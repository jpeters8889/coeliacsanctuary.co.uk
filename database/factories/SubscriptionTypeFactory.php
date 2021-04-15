<?php

declare(strict_types=1);

use Faker\Generator as Faker;

$factory->define(\Coeliac\Modules\Member\Models\DailyUpdateType::class, function (Faker $faker) {
    return [
        'name' => 'Blog Tags',
        'description' => 'Blog Tags',
        'updatable_type' => \Coeliac\Modules\Blog\Models\BlogTag::class,
    ];
});
