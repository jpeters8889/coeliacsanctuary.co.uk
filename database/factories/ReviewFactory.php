<?php

namespace Database\Factories;

use Coeliac\Modules\EatingOut\Reviews\Models\Review;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Illuminate\Support\Str;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition()
    {
        return [
            'wheretoeat_id' => self::factoryForModel(WhereToEat::class),
            'title' => $title = $this->faker->sentence,
            'slug' => $slug = Str::slug($title),
            'legacy_slug' => $slug,
            'body' => $this->faker->paragraph,
            'overall_rating' => $this->faker->numberBetween(1, 5),
            'knowledge_rating' => $this->faker->numberBetween(1, 5),
            'presentation_taste_rating' => $this->faker->numberBetween(1, 5),
            'value_rating' => $this->faker->numberBetween(1, 5),
            'general_rating' => $this->faker->numberBetween(1, 5),
            'live' => true,
            'meta_tags' => $this->faker->paragraph,
            'meta_description' => $this->faker->paragraph,
        ];
    }

    public function notLive()
    {
        return $this->state(fn () => ['live' => false]);
    }

    public function at(WhereToEat $eatery)
    {
        return $this->state(fn () => ['wheretoeat_id' => $eatery->id]);
    }
}
