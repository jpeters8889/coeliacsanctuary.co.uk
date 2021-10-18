<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Models;

use Coeliac\Base\Models\BaseModel;
use Coeliac\Modules\Member\Models\UserAddress;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property ShopProduct $product
 * @property int $product_price
 * @property ShopProductVariant $variant
 * @property int $quantity
 * @property mixed|string $id
 * @property ShopOrder $order
 * @property UserAddress $address
 * @property ShopPostageCountry $postageCountry
 * @property int $product_id
 * @property int $product_variant_id
 * @property string $product_title
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

    public function getSubtotalAttribute(): int
    {
        return $this->product_price * $this->quantity;
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(ShopOrder::class, 'order_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(ShopProduct::class, 'product_id');
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ShopProductVariant::class, 'product_variant_id');
    }
}
