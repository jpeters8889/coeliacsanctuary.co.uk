<?php

declare(strict_types=1);

namespace Coeliac\Architect\Plans\ShopProductVariants;

use Coeliac\Modules\Shop\Models\ShopProductVariant;

class ApiHandler
{
    public function variants($id)
    {
        return ShopProductVariant::query()
            ->where('product_id', $id)
            ->get()
            ->makeVisible(['live', 'title', 'weight', 'quantity']);
    }
}
