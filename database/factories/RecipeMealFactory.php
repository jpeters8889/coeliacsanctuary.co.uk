<?php

namespace Database\Factories;

use Coeliac\Modules\Recipe\Models\RecipeMeal;

class RecipeMealFactory extends Factory
{
    protected $model = RecipeMeal::class;

    public function definition()
    {
        return [
            'meal' => $this->faker->word,
        ];
    }
}
