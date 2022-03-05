<?php

namespace Database\Factories;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatOpeningTimes;

class WhereToEatOpeningTimesFactory extends Factory
{
    protected $model = WhereToEatOpeningTimes::class;

    public function definition()
    {
        return [
            'wheretoeat_id' => static::factoryForModel(WhereToEat::class),
            'monday_start' => $this->faker->numberBetween(0, 12).':00:00',
            'monday_end' => $this->faker->numberBetween(13, 23).':00:00',
            'tuesday_start' => $this->faker->numberBetween(0, 12).':00:00',
            'tuesday_end' => $this->faker->numberBetween(13, 23).':00:00',
            'wednesday_start' => $this->faker->numberBetween(0, 12).':00:00',
            'wednesday_end' => $this->faker->numberBetween(13, 23).':00:00',
            'thursday_start' => $this->faker->numberBetween(0, 12).':00:00',
            'thursday_end' => $this->faker->numberBetween(13, 23).':00:00',
            'friday_start' => $this->faker->numberBetween(0, 12).':00:00',
            'friday_end' => $this->faker->numberBetween(13, 23).':00:00',
            'saturday_start' => $this->faker->numberBetween(0, 12).':00:00',
            'saturday_end' => $this->faker->numberBetween(13, 23).':00:00',
            'sunday_start' => $this->faker->numberBetween(0, 12).':00:00',
            'sunday_end' => $this->faker->numberBetween(13, 23).':00:00',
        ];
    }

    public function forEatery(WhereToEat $eatery)
    {
        return $this->state(fn() => ['wheretoeat_id' => $eatery->id]);
    }
}
