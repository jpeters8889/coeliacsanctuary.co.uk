<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/** @extends BaseModel<ShopSource> */
class ShopSource extends BaseModel
{
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(ShopOrder::class, 'shop_order_sources', 'source_id', 'order_id');
    }
}
