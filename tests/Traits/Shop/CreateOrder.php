<?php

declare(strict_types=1);

namespace Tests\Traits\Shop;

use Illuminate\Support\Str;
use Coeliac\Modules\Shop\Models\ShopOrder;

trait CreateOrder
{
    public function createOrder($params = [])
    {
        return factory(ShopOrder::class)->create(array_merge([
            'state_id' => 1,
            'postage_country_id' => 1,
            'token' => Str::random(8),
        ], $params));
    }
}
