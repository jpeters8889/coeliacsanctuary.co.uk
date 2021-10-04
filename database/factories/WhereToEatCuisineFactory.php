<?php

namespace Database\Factories;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCuisine;
use Illuminate\Support\Str;

class WhereToEatCuisineFactory extends Factory
{
    protected $model = WhereToEatCuisine::class;

    public function definition()
    {
        return [
            'cuisine' => $this->faker->name,
        ];
    }
}
