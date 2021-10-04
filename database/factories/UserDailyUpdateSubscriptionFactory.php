<?php

namespace Database\Factories;

use Coeliac\Modules\Blog\Models\BlogTag;
use Coeliac\Modules\Member\Contracts\Updatable;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\UserDailyUpdateSubscription;

class UserDailyUpdateSubscriptionFactory extends Factory
{
    protected $model = UserDailyUpdateSubscription::class;

    public function definition()
    {
        return [
            'user_id' => self::factoryForModel(User::class),
            'daily_update_type_id' => 1,
            'updatable_type' => BlogTag::class,
            'updatable_id' => 1,
        ];
    }

    public function on(Updatable $updatable)
    {
        return $this->state(fn (array $attributes) => [
            'updatable_type' => $updatable::class,
            'updatable_id' => $updatable->id,
        ]);
    }

    public function forUser(User $user)
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $user->id,
        ]);
    }
}
