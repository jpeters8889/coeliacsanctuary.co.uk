<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Shop\Order;

use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\UserAddress;
use Coeliac\Modules\Shop\Events\CompleteOrder;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopOrderItem;
use Coeliac\Modules\Shop\Models\ShopOrderState;
use Coeliac\Modules\Shop\Models\ShopPayment;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Coeliac\Modules\Shop\Models\ShopProductVariant;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class ShopOrderCompleteEventTest extends TestCase
{
    protected ShopProduct $product;
    protected ShopProductVariant $variant;
    protected User $user;
    protected ShopOrder $order;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->build(User::class)
            ->has($this->build(UserAddress::class)->asShipping(), 'addresses')
            ->create();

        $this->order = $this->build(ShopOrder::class)
            ->asPaid()
            ->to($this->user)
            ->has($this->build(ShopPayment::class), 'payment')
            ->create();

        $this->build(ShopOrderItem::class)
            ->to($this->order)
            ->add($this->build(ShopProductVariant::class)
            ->in($this->build(ShopProduct::class)
            ->has($this->build(ShopProductPrice::class)->state(['price' => 100]), 'prices')
            ->create())
            ->create(['weight' => 10]))
            ->create();
    }

    /** @test */
    public function itUpdatesTheStateToComplete()
    {
        $this->assertNotEquals(ShopOrderState::STATE_COMPLETE, $this->order->state_id);

        Event::dispatch(new CompleteOrder($this->order));

        $this->assertEquals(ShopOrderState::STATE_COMPLETE, $this->order->fresh()->state_id);
    }
}
