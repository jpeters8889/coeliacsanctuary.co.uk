<?php

namespace Database\Factories;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatType;

class WhereToEatTypeFactory extends Factory
{
    protected $model = WhereToEatType::class;

    public function definition()
    {
        return [
            'type' => 'wte',
            'name' => 'Eatery',
        ];
    }
}
