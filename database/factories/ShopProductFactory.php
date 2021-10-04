<?php

namespace Database\Factories;

use Coeliac\Modules\Shop\Models\ShopProduct;

class ShopProductFactory extends Factory
{
    protected $model = ShopProduct::class;

    public function definition()
    {
        return [
            'title' => $this->faker->words(3, true),
            'meta_description' => $this->faker->sentence,
            'meta_keywords' => $this->faker->sentence,
            'slug' => $this->faker->slug,
            'description' => $this->faker->sentence,
            'long_description' => $this->faker->paragraphs(2, true),
            'shipping_method_id' => 1,
            'pinned' => false,
        ];
    }
}
