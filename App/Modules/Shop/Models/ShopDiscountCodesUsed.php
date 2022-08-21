<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** @extends BaseModel<ShopDiscountCodesUsed> */
class ShopDiscountCodesUsed extends BaseModel
{
    protected $table = 'shop_discount_codes_used';

    public function code(): BelongsTo
    {
        return $this->belongsTo(ShopDiscountCode::class, 'code_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(ShopOrder::class, 'order_id');
    }
}
