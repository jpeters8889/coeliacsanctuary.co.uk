<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Models;

use Illuminate\Support\Str;
use Coeliac\Base\Models\BaseModel;
use Coeliac\Modules\Member\Contracts\Updatable;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int user_id
 * @property int daily_update_type_id
 * @property Updatable updatable
 * @property int id
 * @property DailyUpdateType type
 * @property User user
 */
class UserDailyUpdateSubscription extends BaseModel
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'user_id' => 'int',
        'daily_update_type_id' => 'int',
    ];

    protected static function booted()
    {
        self::creating(fn (self $subscription) => $subscription->id = Str::uuid()->toString());
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(DailyUpdateType::class, 'daily_update_type_id');
    }

    public function updatable(): MorphTo
    {
        return $this->morphTo('updatable');
    }
}
