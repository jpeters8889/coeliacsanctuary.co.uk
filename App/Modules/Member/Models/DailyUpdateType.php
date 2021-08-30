<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Models;

use Coeliac\Base\Models\BaseModel;
use Coeliac\Modules\Member\Contracts\Updatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $updatable_type
 * @property int $id
 * @property string $name
 * @property string $description
 */
class DailyUpdateType extends BaseModel
{
    public const BLOG_TAGS = 1;
    public const WTE_COUNTY = 2;
    public const WTE_TOWN = 3;

    public function subscriptions(): HasMany
    {
        return $this->hasMany(UserDailyUpdateSubscription::class, 'daily_update_type_id');
    }

    public function subscribe(User $user, Updatable $updatable): void
    {
        $this->subscriptions()->create([
            'user_id' => $user->id,
            'updatable_type' => get_class($updatable),
            'updatable_id' => $updatable->id,
        ]);
    }
}
