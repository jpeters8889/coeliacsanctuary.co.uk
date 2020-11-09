<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Models;

use Coeliac\Base\Models\BaseModel;

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
    public function order()
    {
        return $this->belongsTo(ShopOrder::class, 'order_id');
    }

    public function type()
    {
        return $this->belongsTo(ShopPaymentType::class, 'payment_type_id');
    }

    public function response()
    {
        return $this->hasOne(ShopPaymentResponse::class, 'payment_id');
    }
}
