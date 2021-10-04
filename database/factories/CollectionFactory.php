<?php

namespace Database\Factories;

use Coeliac\Modules\Collection\Models\Collection;

class CollectionFactory extends Factory
{
    protected $model = Collection::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'meta_keywords' => implode(',', $this->faker->words(5)),
            'meta_description' => $description = $this->faker->paragraph,
            'long_description' => $description,
            'body' => $this->faker->paragraphs(3, true),
        ];
    }
}
