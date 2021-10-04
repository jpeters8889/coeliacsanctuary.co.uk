<?php

namespace Database\Factories;

use Carbon\Carbon;
use Coeliac\Modules\Competition\Models\Competition;

class CompetitionFactory extends Factory
{
    protected $model = Competition::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence,
            'description' => $this->faker->paragraphs(3, true),
            'meta_keywords' => implode(',', $this->faker->words(10)),
            'meta_description' => $this->faker->paragraph,
            'start_at' => Carbon::tomorrow()->startOfDay(),
            'end_at' => Carbon::tomorrow()->addWeek()->endOfDay(),
            'promote_on_banner' => true,
            'enable_facebook_like' => true,
            'enable_facebook_share' => true,
            'enable_twitter_follow' => true,
            'enable_twitter_tweet' => true,
            'enable_shop_purchase' => true,
            'terms' => $this->faker->paragraphs(10, true),
        ];
    }

    public function isForOneDayOnly()
    {
        return $this->state(fn (array $attributes) => [
            'start_at' => Carbon::tomorrow()->startOfDay(),
            'end_at' => Carbon::tomorrow()->endOfDay(),
        ]);
    }

    public function startsNextWeek()
    {
        return $this->state(fn (array $attributes) => [
            'start_at' => Carbon::tomorrow()->addWeek()->startOfDay(),
        ]);
    }

    public function startedYesterday()
    {
        return $this->state(fn (array $attributes) => [
            'start_at' => Carbon::yesterday()->startOfDay(),
        ]);
    }

    public function endsNextWeek()
    {
        return $this->state(fn (array $attributes) => [
            'end_at' => Carbon::now()->addWeek()->endOfDay(),
        ]);
    }
}
