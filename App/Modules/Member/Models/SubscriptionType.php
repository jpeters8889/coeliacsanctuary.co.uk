<?php

namespace Coeliac\Modules\Member\Models;

use Coeliac\Base\Models\BaseModel;
use Coeliac\Modules\Member\Contracts\Subscribable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubscriptionType extends BaseModel
{
    protected $table = 'user_subscription_types';

    public function subscriptions(): HasMany
    {
        return $this->hasMany(UserSubscription::class, 'user_subscription_type_id');
    }

    public function subscribe(User $user, Subscribable $subscribable)
    {
        $this->subscriptions()->create([
            'user_id' => $user->id,
            'subscribable_type' => get_class($subscribable),
            'subscribable_id' => $subscribable->id,
        ]);
    }
}
