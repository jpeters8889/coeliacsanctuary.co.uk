<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

/**
 * @extends BaseModel<ShopOrderReviewInvitation>
 *
 * @property ShopOrder $order
 * @property string $id
 */
class ShopOrderReviewInvitation extends BaseModel
{
    protected $keyType = 'string';

    public $incrementing = false;

    protected $casts = [
        'sent' => 'bool',
        'order_id' => 'int',
    ];

    protected $attributes = ['sent' => false];

    protected $dates = ['sent_at'];

    protected static function booted()
    {
        self::creating(function (self $invitation) {
            $invitation->id = Str::uuid()->toString();

            return $invitation;
        });
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(ShopOrder::class, 'order_id');
    }

    public function review(): HasOne
    {
        return $this->hasOne(ShopOrderReview::class, 'invitation_id');
    }
}
