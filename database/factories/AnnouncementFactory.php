<?php

namespace Database\Factories;

use Carbon\Carbon;
use Coeliac\Common\Models\Announcement;

class AnnouncementFactory extends Factory
{
    protected $model = Announcement::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'text' => $this->faker->paragraph,
            'live' => true,
            'expires_at' => Carbon::now()->addDay(),
        ];
    }

    public function hidden()
    {
        return $this->state(fn () => ['live' => false]);
    }

    public function hasExpired()
    {
        return $this->state(fn () => ['expires_at' => Carbon::now()->subHour()]);
    }
}
