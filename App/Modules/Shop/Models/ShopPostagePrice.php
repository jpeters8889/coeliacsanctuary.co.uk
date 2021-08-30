<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $price
 */
class ShopPostagePrice extends BaseModel
{
    protected $casts = [
        'price' => 'int',
        'max_weight' => 'int',
    ];

    public function area(): BelongsTo
    {
        return $this->belongsTo(ShopPostageCountryArea::class, 'postage_country_area_id');
    }

    public function shippingMethod(): BelongsTo
    {
        return $this->belongsTo(ShopShippingMethod::class, 'shipping_method_id');
    }
}
