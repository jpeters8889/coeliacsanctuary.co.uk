<?php

namespace Database\Factories;

use Coeliac\Modules\Recipe\Models\RecipeAllergen;

class RecipeAllergenFactory extends Factory
{
    protected $model = RecipeAllergen::class;

    public function definition()
    {
        return [
            'allergen' => $this->faker->word,
        ];
    }
}
