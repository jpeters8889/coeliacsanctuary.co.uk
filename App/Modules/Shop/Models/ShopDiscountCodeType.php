<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Models;

use Coeliac\Base\Models\BaseModel;

class ShopDiscountCodeType extends BaseModel
{
    public const PERCENTAGE = 1;
    public const MONEY = 2;

    public function codes()
    {
        return $this->hasMany(ShopDiscountCode::class, 'type_id');
    }
}
