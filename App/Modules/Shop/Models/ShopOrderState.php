<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Models;

use Coeliac\Base\Models\BaseModel;

class ShopOrderState extends BaseModel
{
    public const STATE_BASKET = 1;
    public const STATE_PAID = 2;
    public const STATE_PRINTED = 3;
    public const STATE_SHIPPED = 4;
    public const STATE_COMPLETE = 5;
    public const STATE_REFUNDED = 6;
    public const STATE_CANCELLED = 7;
    public const STATE_EXPIRED = 8;

    public function order()
    {
        return $this->hasMany(ShopOrder::class, 'state_id');
    }
}
