<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Events;

use Illuminate\Queue\SerializesModels;
use Coeliac\Modules\Shop\Models\ShopOrder;

class CompleteOrder
{
    use SerializesModels;

    protected ShopOrder $order;

    public function __construct(ShopOrder $order)
    {
        $this->order = $order;
    }

    public function order(): ShopOrder
    {
        return $this->order;
    }
}
