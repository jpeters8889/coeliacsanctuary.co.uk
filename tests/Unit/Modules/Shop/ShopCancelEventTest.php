<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Shop;

use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\UserAddress;
use Coeliac\Modules\Shop\Events\CancelOrder;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopOrderState;
use Coeliac\Modules\Shop\Models\ShopPayment;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopProductVariant;
use Coeliac\Modules\Shop\Notifications\OrderCancelledNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Tests\Traits\HasImages;

class ShopCancelEventTest extends TestCase
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
    }

    private function dispatchEvent()
    {
        Event::dispatch(new CancelOrder($this->order));
    }

    /** @test */
    public function itUpdatesTheStateToCancelled()
    {
        $this->assertNotEquals(ShopOrderState::STATE_CANCELLED, $this->order->state_id);

        $this->dispatchEvent();

        $this->assertEquals(ShopOrderState::STATE_CANCELLED, $this->order->fresh()->state_id);
    }

    /** @test */
    public function itNotifiesTheUserThatTheOrderHasBeenCancelled()
    {
        $this->dispatchEvent();

        Notification::assertSentTo(
            $this->user,
            OrderCancelledNotification::class,
            function (OrderCancelledNotification $notification) {
                return $notification->order->is($this->order);
            }
        );
    }
}
