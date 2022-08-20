<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property ShopOrderReview $parent
 * @property int $rating
 * @property string $review
 */
class ShopOrderReviewItem extends BaseModel
{
    public function product(): BelongsTo
    {
        return $this->belongsTo(ShopProduct::class, 'product_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(ShopOrderReview::class, 'review_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(ShopOrder::class, 'order_id');
    }
}
