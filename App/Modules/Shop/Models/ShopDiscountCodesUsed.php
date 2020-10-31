<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Models;

use Coeliac\Base\Models\BaseModel;

class ShopDiscountCodesUsed extends BaseModel
{
    protected $table = 'shop_discount_codes_used';

    public function code()
    {
        return $this->belongsTo(ShopDiscountCode::class, 'code_id');
    }

    public function order()
    {
        return $this->belongsTo(ShopOrder::class, 'order_id');
    }
}
