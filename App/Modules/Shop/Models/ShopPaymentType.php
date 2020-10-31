<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Models;

use Coeliac\Base\Models\BaseModel;

class ShopPaymentType extends BaseModel
{
    public function payment()
    {
        return $this->hasMany(ShopPayment::class, 'payment_type_id');
    }
}
