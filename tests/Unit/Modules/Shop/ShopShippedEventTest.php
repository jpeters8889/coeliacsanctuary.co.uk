<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Shop;

use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\UserAddress;
use Coeliac\Modules\Shop\Events\CompleteOrder;
use Coeliac\Modules\Shop\Events\ShipOrder;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopOrderState;
use Coeliac\Modules\Shop\Models\ShopPayment;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopProductVariant;
use Coeliac\Modules\Shop\Notifications\OrderShippedNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Tests\Traits\HasImages;

class ShopShippedEventTest extends TestCase
{
    use HasImages;

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

        Notification::fake();
        Event::fake([CompleteOrder::class]);
    }

    private function dispatchEvent()
    {
        Event::dispatch(new ShipOrder($this->order));
    }

    /** @test */
    public function itUpdatesTheStateToShipped()
    {
        $this->assertNotEquals(ShopOrderState::STATE_SHIPPED, $this->order->state_id);

        $this->dispatchEvent();

        $this->assertEquals(ShopOrderState::STATE_SHIPPED, $this->order->fresh()->state_id);
    }

    /** @test */
    public function itNotifiesTheUserThatTheOrderHasBeenShipped()
    {
        $this->dispatchEvent();

        Notification::assertSentTo(
            $this->user,
            OrderShippedNotification::class,
            function (OrderShippedNotification $notification) {
                return $notification->order->is($this->order);
            }
        );
    }

    /** @test */
    public function itDispatchesAnOrderCompleteEvent()
    {
        $this->dispatchEvent();

        Event::assertDispatched(CompleteOrder::class);
    }
}
