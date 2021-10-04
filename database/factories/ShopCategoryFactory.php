<?php

namespace Database\Factories;

use Coeliac\Modules\Shop\Models\ShopCategory;

class ShopCategoryFactory extends Factory
{
    protected $model = ShopCategory::class;

    public function definition()
    {
        return [
            'title' => $this->faker->title,
            'description' => $this->faker->sentence,
            'slug' => $this->faker->slug,
            'meta_keywords' => $this->faker->sentence,
            'meta_description' => $this->faker->sentence,
        ];
    }
}
