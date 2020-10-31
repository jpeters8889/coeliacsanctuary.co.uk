<?php

declare(strict_types=1);

use Faker\Generator as Faker;

$factory->define(\Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatVenueType::class, function (Faker $faker) {
    return [
        'venue_type' => $faker->word,
        'type_id' => 1,
    ];
});
