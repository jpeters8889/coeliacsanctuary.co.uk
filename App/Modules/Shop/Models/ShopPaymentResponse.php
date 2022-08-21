<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** @extends BaseModel<ShopPaymentResponse> */
class ShopPaymentResponse extends BaseModel
{
    protected $casts = [
        'response' => 'array',
    ];

    public function payment(): BelongsTo
    {
        return $this->belongsTo(ShopPayment::class, 'payment_id');
    }
}
