<?php

namespace Database\Factories;

use Carbon\Carbon;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\UserLevel;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'email_verified_at' => Carbon::now(),
            'phone' => $this->faker->phoneNumber,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
            'user_level_id' => UserLevel::SHOP,
        ];
    }

    public function notVerified()
    {
        return $this->state(fn () => ['email_verified_at' => null]);
    }

    public function asShop()
    {
        return $this->state(fn () => ['user_level_id' => UserLevel::SHOP, 'password' => null]);
    }

    public function asMember()
    {
        return $this->state(fn () => ['user_level_id' => UserLevel::MEMBER]);
    }

    public function asAdmin()
    {
        return $this->state(fn () => ['user_level_id' => UserLevel::ADMIN]);
    }
}
