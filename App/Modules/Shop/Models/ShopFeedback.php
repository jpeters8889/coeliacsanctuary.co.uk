<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Models;

use Coeliac\Base\Models\BaseModel;

class ShopFeedback extends BaseModel
{
    protected $table = 'shop_feedback';

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(ShopProduct::class, 'product_id');
    }
}
