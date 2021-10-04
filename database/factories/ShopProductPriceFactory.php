<?php

namespace Database\Factories;

use Carbon\Carbon;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopProductPrice;

class ShopProductPriceFactory extends Factory
{
    protected $model = ShopProductPrice::class;

    public function definition()
    {
        return [
            'price' => $this->faker->numberBetween(100, 1500),
            'start_at' => Carbon::now()->subHour()->toDateTimeString(),
            'sale_price' => false,
        ];
    }

    public function in(ShopProduct $product)
    {
        return $this->state(fn () => [
           'product_id' => $product->id,
        ]);
    }

    public function onSale()
    {
        return $this->state(fn () => [
            'sale_price' => true,
        ]);
    }
}
