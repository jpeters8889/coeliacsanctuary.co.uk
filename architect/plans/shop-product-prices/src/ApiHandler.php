<?php

declare(strict_types=1);

namespace Coeliac\Architect\Plans\ShopProductPrices;

use Coeliac\Modules\Shop\Models\ShopProductPrice;

class ApiHandler
{
    public function prices($id)
    {
        return ShopProductPrice::query()
            ->where('product_id', $id)
            ->orderByDesc('id')
            ->get();
    }
}
