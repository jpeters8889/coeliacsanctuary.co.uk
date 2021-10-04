<?php

namespace Database\Factories;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatSearchTerm;

class WhereToEatSearchTermFactory extends Factory
{
    protected $model = WhereToEatSearchTerm::class;

    public function definition()
    {
        return [
            'term' => $this->faker->word,
            'range' => $this->faker->randomElement(['1', '2', '5', '10', '20']),
        ];
    }
}
