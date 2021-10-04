<?php

namespace Database\Factories;

use Carbon\Carbon;
use Coeliac\Modules\Shop\Models\ShopDiscountCode;
use Coeliac\Modules\Shop\Models\ShopDiscountCodeType;
use Illuminate\Support\Str;

class ShopDiscountCodeFactory extends Factory
{
    protected $model = ShopDiscountCode::class;

    public function definition()
    {
        return [
            'name' => $name = $this->faker->sentence,
            'code' => Str::slug($name),
            'start_at' => Carbon::now()->startOfDay(),
            'end_at' => Carbon::now()->addWeek(),
            'max_claims' => 5,
            'min_spend' => 1,
            'deduction' => 10,
            'type_id' => 1,
        ];
    }

    public function percentageDiscount()
    {
        return $this->state(fn () => [
            'type_id' => ShopDiscountCodeType::PERCENTAGE,
        ]);
    }

    public function moneyDiscount()
    {
        return $this->state(fn () => [
            'type_id' => ShopDiscountCodeType::MONEY,
        ]);
    }

    public function startsTomorrow()
    {
        return $this->state(fn () => [
            'start_at' => Carbon::tomorrow(),
        ]);
    }

    public function expired()
    {
        return $this->state(fn () => [
            'end_at' => Carbon::yesterday(),
        ]);
    }
}
