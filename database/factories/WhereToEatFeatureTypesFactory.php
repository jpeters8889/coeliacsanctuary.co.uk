<?php

declare(strict_types=1);

use Faker\Generator as Faker;

$factory->define(\Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatFeature::class, function (Faker $faker) {
    return [
        'feature' => $faker->word,
        'icon' => $faker->word,
    ];
});
