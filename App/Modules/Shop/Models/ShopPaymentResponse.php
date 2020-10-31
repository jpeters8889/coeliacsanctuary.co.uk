<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Models;

use Coeliac\Base\Models\BaseModel;

class ShopPaymentResponse extends BaseModel
{
    protected $casts = [
        'response' => 'array',
    ];

    public function payment()
    {
        return $this->belongsTo(ShopPayment::class, 'payment_id');
    }
}
