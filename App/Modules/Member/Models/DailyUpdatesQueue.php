<?php

namespace Coeliac\Modules\Member\Models;

use Coeliac\Base\Models\BaseModel;

/**
 * @property BaseModel newItem
 * @property UserDailyUpdateSubscription subscription
 */
class DailyUpdatesQueue extends BaseModel
{
    protected $table = 'daily_updates_queue';

    public static function queueItemForUser(BaseModel $item, UserDailyUpdateSubscription $subscription)
    {
        return static::query()->create([
            'user_daily_update_id' => $subscription->id,
            'user_id' => $subscription->user_id,
            'new_item_type' => get_class($item),
            'new_item_id' => $item->id,
        ]);
    }

    public function newItem() {
        return $this->morphTo('new_item');
    }

    public function subscription()
    {
        return $this->belongsTo(UserDailyUpdateSubscription::class, 'user_daily_update_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
