<?php

namespace Database\Factories;

use Coeliac\Modules\Shop\Models\ShopPayment;

class ShopPaymentFactory extends Factory
{
    protected $model = ShopPayment::class;

    public function definition()
    {
        return [
            'subtotal' => 100,
            'discount' => 0,
            'postage' => 100,
            'total' => 200,
            'payment_type_id' => 1,
        ];
    }
}
