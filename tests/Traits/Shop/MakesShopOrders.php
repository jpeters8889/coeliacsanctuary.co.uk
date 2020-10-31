<?php

declare(strict_types=1);

namespace Tests\Traits\Shop;

use Coeliac\Modules\Shop\Models\ShopOrderState;
use Coeliac\Modules\Shop\Models\ShopPaymentType;

trait MakesShopOrders
{
    use CreateOrder;
    use HasPostageOptions;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setupPostage();
        $this->setupOrders();
    }

    private function setupOrders()
    {
        factory(ShopOrderState::class)->create(['state' => 'Basket']);
        factory(ShopOrderState::class)->create(['state' => 'Order']);
        factory(ShopOrderState::class)->create(['state' => 'Processing']);
        factory(ShopOrderState::class)->create(['state' => 'Shipped']);
        factory(ShopOrderState::class)->create(['state' => 'Complete']);
        factory(ShopOrderState::class)->create(['state' => 'Refund']);
        factory(ShopOrderState::class)->create(['state' => 'Cancelled']);

        factory(ShopPaymentType::class)->create(['type' => 'Stripe']);
        factory(ShopPaymentType::class)->create(['type' => 'PayPal']);
    }
}
