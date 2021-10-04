<?php

namespace Database\Factories;

use Coeliac\Modules\Shop\Models\ShopPaymentResponse;

class ShopPaymentResponseFactory extends Factory
{
    protected $model = ShopPaymentResponse::class;

    public function definition()
    {
        return [
            'response' => $this->faker->paragraphs(3, true),
        ];
    }
}
