<?php

namespace Database\Factories;

use Carbon\Carbon;
use Coeliac\Modules\Shop\Models\ShopMassDiscount;

class ShopMassDiscountFactory extends Factory
{
    protected $model = ShopMassDiscount::class;

    public function definition()
    {
        return [
            'title' => $this->faker->word,
            'percentage' => random_int(5, 50),
            'start_at' => Carbon::now(),
            'end_at' => Carbon::now()->addDay(),
            'created' => false,
        ];
    }
}
