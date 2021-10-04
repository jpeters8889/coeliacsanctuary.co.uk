<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Shop;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Str;
use Tests\Traits\HasImages;
use Coeliac\Common\Models\Image;
use Illuminate\Support\Facades\Event;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Events\CancelOrder;
use Coeliac\Modules\Shop\Models\ShopPayment;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Illuminate\Support\Facades\Notification;
use Coeliac\Modules\Member\Models\UserAddress;
use Coeliac\Modules\Shop\Models\ShopOrderItem;
use Coeliac\Modules\Shop\Models\ShopOrderState;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Coeliac\Modules\Shop\Models\ShopProductVariant;
use Coeliac\Modules\Shop\Notifications\OrderCancelledNotification;

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
