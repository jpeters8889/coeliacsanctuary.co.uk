<?php

namespace Database\Factories;

use Coeliac\Modules\Member\Models\Scrapbook;
use Coeliac\Modules\Member\Models\User;

class ScrapbookFactory extends Factory
{
    protected $model = Scrapbook::class;

    public function definition()
    {
        return [
            'user_id' => self::factoryForModel(User::class),
            'name' => 'My Scrapbook',
        ];
    }

    public function in(User $user)
    {
        return $this->state(fn () => ['user_id' => $user->id]);
    }
}
