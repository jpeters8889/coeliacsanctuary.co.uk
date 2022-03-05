<?php

namespace Database\Factories;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCountry;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatTown;

class WhereToEatFactory extends Factory
{
    protected $model = WhereToEat::class;

    public function definition()
    {
        return [
            'name' => $this->faker->title,
            'slug' => $this->faker->slug,
            'town_id' => 1,
            'county_id' => 1,
            'country_id' => 1,
            'type_id' => 1,
            'venue_type_id' => 1,
            'cuisine_id' => 1,
            'info' => $this->faker->sentence,
            'address' => str_replace(', ', '<br />', $this->faker->address),
            'phone' => $this->faker->phoneNumber,
            'website' => $this->faker->url,
            'lat' => $this->faker->latitude,
            'lng' => $this->faker->longitude,
            'live' => true,
        ];
    }

    public function withOutSlug() {
        return $this->state(fn () => ['slug' => null]);
    }
}
