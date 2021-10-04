<?php

namespace Database\Factories;

use Coeliac\Common\Models\Popup;

class PopupFactory extends Factory
{
    protected $model = Popup::class;

    public function definition()
    {
        return [
            'text' => $this->faker->paragraph,
            'link' => $this->faker->url,
            'display_every' => random_int(1, 7),
            'live' => true,
        ];
    }
}
