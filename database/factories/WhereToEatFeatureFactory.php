<?php

namespace Database\Factories;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatFeature;

class WhereToEatFeatureFactory extends Factory
{
    protected $model = WhereToEatFeature::class;

    public function definition()
    {
        return [
            'icon' => $this->faker->word,
            'feature' => $this->faker->word,
        ];
    }
}
