<?php

namespace Database\Factories;

use Coeliac\Modules\Recipe\Models\RecipeFeature;

class RecipeFeatureFactory extends Factory
{
    protected $model = RecipeFeature::class;

    public function definition()
    {
        return [
            'feature' => $this->faker->word,
            'icon' => $this->faker->word,
        ];
    }
}
