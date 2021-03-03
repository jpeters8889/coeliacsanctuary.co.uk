<?php

namespace Coeliac\Modules\Member\Models;

use Coeliac\Base\Models\BaseModel;

class DailyUpdatesQueue extends BaseModel
{
    protected $table = 'daily_updates_queue';

    public static function queueItemForUser(BaseModel $item, UserDailyUpdateSubscription $subscription)
    {
        return static::query()->create([
            'user_daily_update_id' => $subscription->id,
            'new_item_type' => get_class($item),
            'new_item_id' => $item->id,
        ]);
    }
}
