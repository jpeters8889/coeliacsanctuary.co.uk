<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property mixed|string $id
 */
class ShopShippingMethod extends BaseModel
{
    public function products(): HasMany
    {
        return $this->hasMany(ShopProduct::class);
    }

    public function prices()
    {
        return $this->hasMany(ShopPostagePrice::class, 'shipping_method_id');
    }
}
