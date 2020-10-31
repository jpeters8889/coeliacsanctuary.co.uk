<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Events;

use Illuminate\Queue\SerializesModels;
use Coeliac\Modules\Shop\Models\ShopOrder;

class BasketClosed
{
    use SerializesModels;

    protected ShopOrder $basket;

    public function __construct(ShopOrder $basket)
    {
        $this->basket = $basket;
    }

    public function order(): ShopOrder
    {
        return $this->basket;
    }
}
