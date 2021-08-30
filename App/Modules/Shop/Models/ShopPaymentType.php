<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShopPaymentType extends BaseModel
{
    public function payment(): HasMany
    {
        return $this->hasMany(ShopPayment::class, 'payment_type_id');
    }
}
