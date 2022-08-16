<?php

namespace Database\Factories;

use Carbon\Carbon;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\UserAddress;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopOrderState;
use Illuminate\Support\Str;

class ShopOrderFactory extends Factory
{
    protected $model = ShopOrder::class;

    public function definition()
    {
        return [
            'state_id' => ShopOrderState::STATE_BASKET,
            'token' => Str::random(8),
            'postage_country_id' => 1,
            'user_id' => self::factoryForModel(User::class)
                ->has(self::factoryForModel(UserAddress::class)->asShipping(), 'addresses')
                ->create()
                ->id,
            'user_address_id' => 1,
        ];
    }

    public function to(User $user, ?UserAddress $address = null)
    {
        return $this->state(fn () => [
            'user_id' => $user->id,
            'user_address_id' => $address?->id ?? $user->addresses()->firstWhere('type', 'Shipping')->id,
        ]);
    }

    public function asBasket()
    {
        return $this->state(fn () => [
            'state_id' => ShopOrderState::STATE_BASKET,
        ]);
    }

    public function asPaid()
    {
        return $this->state(fn () => [
            'state_id' => ShopOrderState::STATE_PAID,
            'order_key' => random_int(10000000, 99999999),
        ]);
    }

    public function asCompleted()
    {
        return $this->state(fn () => [
            'state_id' => ShopOrderState::STATE_COMPLETE,
            'order_key' => random_int(10000000, 99999999),
            'shipped_at' => Carbon::now(),
        ]);
    }
}
