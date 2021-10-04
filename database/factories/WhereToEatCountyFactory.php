<?php

namespace Database\Factories;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatTown;
use Illuminate\Support\Str;

class WhereToEatCountyFactory extends Factory
{
    protected $model = WhereToEatCounty::class;

    public function definition()
    {
        $county = $this->faker->state;

        return [
            'country_id' => 1,
            'county' => $county,
            'slug' => Str::slug($county),
            'legacy' => ucfirst(Str::slug($county)),
        ];
    }
}
