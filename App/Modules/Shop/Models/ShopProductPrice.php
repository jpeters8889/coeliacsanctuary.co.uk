<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Models;

use Carbon\Carbon;
use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Carbon      $start_at
 * @property Carbon|null $end_at
 */
class ShopProductPrice extends BaseModel
{
    protected $dates = ['start_at', 'end_at'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(ShopProduct::class, 'product_id');
    }
}
