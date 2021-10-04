<?php

namespace Database\Factories;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatVenueType;

class WhereToEatVenueTypeFactory extends Factory
{
    protected $model = WhereToEatVenueType::class;

    public function definition()
    {
        return [
            'venue_type' => $this->faker->word,
            'type_id' => 1,
        ];
    }
}
