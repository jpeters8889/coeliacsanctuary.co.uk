<?php

declare(strict_types=1);

namespace Coeliac\Architect\Plans\CoeliacShopOrderItems;

use Coeliac\Modules\Shop\Models\ShopOrderItem;

class ApiHandler
{
    public function items($id)
    {
        return ShopOrderItem::query()
            ->where('order_id', $id)
            ->get()
            ->makeVisible('product_title');
    }
}
