<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Models;

use Coeliac\Base\Models\BaseModel;
use Coeliac\Modules\Member\Contracts\Subscribable;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string subscribable_type
 * @property int id
 * @property string name
 * @property string description
 */
class SubscriptionType extends BaseModel
{
    public const BLOG_TAGS = 1;
    public const WTE_COUNTY = 2;
    public const WTE_TOWN = 3;

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
