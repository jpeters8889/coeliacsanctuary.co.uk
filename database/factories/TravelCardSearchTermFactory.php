<?php

namespace Database\Factories;

use Coeliac\Modules\Shop\Models\TravelCardSearchTerm;

class TravelCardSearchTermFactory extends Factory
{
    protected $model = TravelCardSearchTerm::class;

    public function definition()
    {
        return [
            'term' => $this->faker->word,
            'type' => $this->faker->randomElement(['country', 'language']),
            'hits' => 0,
        ];
    }
}
