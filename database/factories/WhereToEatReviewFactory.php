<?php

namespace Database\Factories;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatReview;

class WhereToEatReviewFactory extends Factory
{
    protected $model = WhereToEatReview::class;

    public function definition()
    {
        return [
            'rating' => $this->faker->numberBetween(1, 5),
            'ip' => $this->faker->ipv6,
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'price_range' => $this->faker->numberBetween(1, 5),
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
