<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Models;

use Illuminate\Support\Str;
use Coeliac\Base\Models\BaseModel;
use Coeliac\Modules\Member\Contracts\Subscribable;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int user_id
 * @property int user_subscription_type_id
 * @property Subscribable subscribable
 * @property int id
 * @property SubscriptionType type
 */
class UserSubscription extends BaseModel
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'user_id' => 'int',
        'user_subscription_type_id' => 'int',
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
        return $this->belongsTo(SubscriptionType::class, 'user_subscription_type_id');
    }

    public function subscribable(): MorphTo
    {
        return $this->morphTo('subscribable');
    }
}
