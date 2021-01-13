<?php

declare(strict_types=1);

namespace Tests\Traits\Shop;

use Illuminate\Support\Arr;

trait MakeOrderRequest
{
    /** @var \Faker\Generator */
    protected $faker;

    private function makeOrderRequest($params = [], $method = 'stripe', $token = '123abc')
    {
        $this->faker = $this->makeFaker('en_gb');

        $return = [
            'user' => [
                'name' => $this->faker->name,
                'email' => $email = $this->faker->email,
                'emailConfirmation' => $email,
            ],
            'shipping' => [
                'postcode' => $this->faker->postcode,
                'address1' => $this->faker->streetAddress,
                'town' => $this->faker->city,
            ],
            'billing' => [
                'name' => $this->faker->name,
                'address1' => $this->faker->streetAddress,
                'town' => $this->faker->city,
                'postcode' => $this->faker->postcode,
                'country' => 'United Kingdom',
            ],
            'payment' => [
                'provider' => $method,
                'token' => $token,
            ],
        ];

        foreach ($params as $key => $value) {
            Arr::set($return, $key, $value);
        }

        return $return;
    }
}
