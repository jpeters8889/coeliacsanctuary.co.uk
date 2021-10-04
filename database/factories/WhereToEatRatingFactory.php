<?php

namespace Database\Factories;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatRating;

class WhereToEatRatingFactory extends Factory
{
    protected $model = WhereToEatRating::class;

    public function definition()
    {
        return [
            'rating' => $this->faker->numberBetween(1, 5),
            'ip' => $this->faker->ipv6,
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'body' => $this->faker->paragraph,
            'method' => 'test',
            'approved' => false,
        ];
    }

    public function on(WhereToEat $eatery)
    {
        return $this->state(fn (array $attributes) => [
           'wheretoeat_id' => $eatery->id,
        ]);
    }
}
