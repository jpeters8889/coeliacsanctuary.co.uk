<?php

namespace Database\Factories;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCountry;

class WhereToEatCountryFactory extends Factory
{
    protected $model = WhereToEatCountry::class;

    public function definition()
    {
        return [
            'country' => 'England',
        ];
    }
}
