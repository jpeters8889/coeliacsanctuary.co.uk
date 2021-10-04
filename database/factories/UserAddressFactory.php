<?php

namespace Database\Factories;

use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\UserAddress;

class UserAddressFactory extends Factory
{
    protected $model = UserAddress::class;

    public function definition()
    {
        return [
            'type' => $this->faker->randomElement(['Shipping', 'Billing']),
            'name' => $this->faker->name,
            'line_1' => $this->faker->buildingNumber,
            'line_2' => $this->faker->streetAddress,
            'town' => $this->faker->city,
            'postcode' => $this->faker->postcode,
            'country' => 'England',
        ];
    }

    public function to(User $user)
    {
        return $this->state(fn () => ['user_id' => $user->id]);
    }

    public function asShipping()
    {
        return $this->state(['type' => 'Shipping']);
    }

    public function asBilling()
    {
        return $this->state(['type' => 'Billing']);
    }
}
