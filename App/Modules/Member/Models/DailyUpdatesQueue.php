<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property BaseModel $newItem
 * @property UserDailyUpdateSubscription $subscription
 */
class DailyUpdatesQueue extends BaseModel
{
    protected $table = 'daily_updates_queue';

    public static function queueItemForUser(BaseModel $item, UserDailyUpdateSubscription $subscription): static|self
    {
        return static::query()->create([
            'user_daily_update_id' => $subscription->id,
            'user_id' => $subscription->user_id,
            'new_item_type' => get_class($item),
            'new_item_id' => $item->id,
        ]);
    }

    public function newItem(): MorphTo
    {
        return $this->morphTo('new_item');
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(UserDailyUpdateSubscription::class, 'user_daily_update_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
