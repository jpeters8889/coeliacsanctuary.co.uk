<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Models;

use Coeliac\Base\Models\BaseModel;

/**
 * @property ShopProduct        $product
 * @property int                $product_price
 * @property ShopProductVariant $variant
 * @property int                $quantity
 * @property mixed|string       $id
 * @property ShopOrder          $order
 */
class ShopOrderItem extends BaseModel
{
    protected $appends = [
        'subtotal',
    ];

    protected $casts = [
        'product_price' => 'int',
        'quantity' => 'int',
        'subtotal' => 'int',
    ];

    protected $visible = [
        'quantity',
        'product_price',
        'subtotal',
        'product',
        'variant',
    ];

    public function getSubtotalAttribute()
    {
        return $this->product_price * $this->quantity;
    }

    public function order()
    {
        return $this->belongsTo(ShopOrder::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(ShopProduct::class, 'product_id');
    }

    public function variant()
    {
        return $this->belongsTo(ShopProductVariant::class, 'product_variant_id');
    }
}
