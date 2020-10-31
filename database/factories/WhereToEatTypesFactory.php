<?php

declare(strict_types=1);

use Faker\Generator as Faker;

$factory->define(\Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatType::class, function (Faker $faker) {
    return [
        'type' => 'wte',
        'name' => 'Eatery',
    ];
});
