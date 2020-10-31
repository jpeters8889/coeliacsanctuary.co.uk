<?php

declare(strict_types=1);

use Faker\Generator as Faker;

$factory->define(\Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty::class, function (Faker $faker) {
    $county = $faker->state;

    return [
        'county' => $county,
        'slug' => \Illuminate\Support\Str::slug($county),
        'legacy' => ucfirst(\Illuminate\Support\Str::slug($county)),
    ];
});
