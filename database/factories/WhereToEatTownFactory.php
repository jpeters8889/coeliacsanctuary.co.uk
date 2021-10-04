<?php

namespace Database\Factories;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatTown;
use Illuminate\Support\Str;

class WhereToEatTownFactory extends Factory
{
    protected $model = WhereToEatTown::class;

    public function definition()
    {
        $town = $this->faker->city;

        return [
            'county_id' => 1,
            'town' => $town,
            'slug' => Str::slug($town),
            'legacy' => Str::slug($town),
        ];
    }
}
