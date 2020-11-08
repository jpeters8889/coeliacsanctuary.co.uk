<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int          $id
 * @property mixed|string $quantity
 * @property mixed|string $title
 * @property mixed|string $weight
 * @property ShopProduct  $product
 * @property bool         $live
 */
class ShopProductVariant extends BaseModel
{
    protected $casts = [
        'price' => 'int',
        'sale_price' => 'bool',
        'quantity' => 'int',
    ];

    protected $visible = [
        'id',
        'product_id',
        'title',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(ShopProduct::class);
    }
}
