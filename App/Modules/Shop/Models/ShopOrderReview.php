<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property ShopOrder $order
 * @property string $name
 */
class ShopOrderReview extends BaseModel
{
    public function invitation(): BelongsTo
    {
        return $this->belongsTo(ShopOrderReviewInvitation::class, 'invitation_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(ShopOrder::class, 'order_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(ShopOrderReviewItem::class, 'review_id');
    }
}
