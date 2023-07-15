<?php

namespace Database\Factories;

use Coeliac\Modules\EatingOut\WhereToEat\Models\NationwideBranch;

class NationwideBranchFactory extends Factory
{
    protected $model = NationwideBranch::class;

    public function definition()
    {
        return [
            'name' => $this->faker->title,
            'town_id' => 1,
            'county_id' => 1,
            'country_id' => 1,
            'address' => str_replace(', ', '<br />', $this->faker->address),
            'lat' => $this->faker->latitude,
            'lng' => $this->faker->longitude,
            'live' => true,
        ];
    }

    public function notLive()
    {
        return $this->state(fn () => ['live' => false]);
    }
}
