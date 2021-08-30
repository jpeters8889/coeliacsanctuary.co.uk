<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property ShopOrder           $order
 * @property ShopPaymentType     $type
 * @property ShopPaymentResponse $response
 * @property mixed|string        $id
 * @property mixed|string        $postage
 * @property mixed|string        $subtotal
 * @property mixed|string        $total
 */
class ShopPayment extends BaseModel
{
    protected $casts = [
      'subtotal' => 'int',
      'discount' => 'int',
      'postage' => 'int',
      'total' => 'int',
    ];

    protected $appends = ['payment_type'];

    public function order(): BelongsTo
    {
        return $this->belongsTo(ShopOrder::class, 'order_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(ShopPaymentType::class, 'payment_type_id');
    }

    public function response(): HasOne
    {
        return $this->hasOne(ShopPaymentResponse::class, 'payment_id');
    }

    public function getPaymentTypeAttribute(): string
    {
        return $this->type->type === 'Stripe' ? 'Card' : 'PayPal';
    }
}
