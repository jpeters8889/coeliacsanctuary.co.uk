<?php

namespace Database\Factories;

use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopProductVariant;

class ShopProductVariantFactory extends Factory
{
    protected $model = ShopProductVariant::class;

    public function definition()
    {
        return [
            'live' => true,
            'title' => $this->faker->words(3, true),
            'weight' => $this->faker->numberBetween(1, 20),
            'quantity' => $this->faker->numberBetween(1, 500),
            'product_id' => self::factoryForModel(ShopProduct::class),
        ];
    }

    public function in(ShopProduct $product)
    {
        return $this->state(fn () => [
            'product_id' => $product->id,
        ]);
    }

    public function notLive()
    {
        return $this->state(fn () => ['live' => false]);
    }

    public function outOfStock()
    {
        return $this->state(fn () => ['quantity' => 0]);
    }
}
