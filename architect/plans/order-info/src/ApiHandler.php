<?php

declare(strict_types=1);

namespace Coeliac\Architect\Plans\OrderInfo;

use Coeliac\Modules\Shop\Models\ShopOrder;

class ApiHandler
{
    public function get($id)
    {
        $order = ShopOrder::query()
            ->with(['items', 'user', 'address', 'payment', 'payment.type', 'discountCode'])
            ->findOrFail($id)
            ->makeVisible(['items.product_title', 'items.product_price'])
            ->makeHidden(['user.password', 'user.api_token', 'user.remember_token']);

        $order->items->makeVisible(['product_title', 'product_price']);
        $order->user->makeHidden(['password', 'api_token', 'remember_token']);

        return $order;
    }
}
