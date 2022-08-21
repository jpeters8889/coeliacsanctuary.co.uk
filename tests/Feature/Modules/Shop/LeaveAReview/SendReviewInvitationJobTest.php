<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Shop\LeaveAReview;

use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\UserAddress;
use Coeliac\Modules\Shop\Jobs\SendReviewInvitation;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopOrderItem;
use Coeliac\Modules\Shop\Models\ShopPayment;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Coeliac\Modules\Shop\Models\ShopProductVariant;
use Coeliac\Modules\Shop\Notifications\LeaveAReviewNotification;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SendReviewInvitationJobTest extends TestCase
{
    protected User $user;
    protected ShopOrder $order;

    protected function setUp(): void
    {
        parent::setUp();

        Notification::fake();

        $this->user = $this->build(User::class)
            ->has($this->build(UserAddress::class)->asShipping(), 'addresses')
            ->create();

        $this->order = $this->build(ShopOrder::class)
            ->asCompleted()
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
    public function itSendsANotificationInvitingThemToCompleteAReview(): void
    {
        Notification::assertNothingSent();

        Bus::dispatchNow(new SendReviewInvitation($this->order));

        Notification::assertSentTo($this->user, LeaveAReviewNotification::class);
    }

    /** @test */
    public function itHasTheCorrectSubjectLine(): void
    {
        Bus::dispatchNow(new SendReviewInvitation($this->order));

        Notification::assertSentTo($this->user, LeaveAReviewNotification::class, function (LeaveAReviewNotification $notification) {
            $this->assertEquals('Coeliac Sanctuary - Review Your Purchase', $notification->toMail($this->user)->subject);

            return true;
        });
    }

    /** @test */
    public function itHasTheCustomersNameInTheEmailBody(): void
    {
        Bus::dispatchNow(new SendReviewInvitation($this->order));

        Notification::assertSentTo($this->user, LeaveAReviewNotification::class, function (LeaveAReviewNotification $notification) {
            $this->assertStringContainsString($this->order->address->name, $notification->toMail($this->user)->render());

            return true;
        });
    }

    /** @test */
    public function itHasALinkToLeaveAReviewInTheEmailBody(): void
    {
        Bus::dispatchNow(new SendReviewInvitation($this->order));

        Notification::assertSentTo($this->user, LeaveAReviewNotification::class, function (LeaveAReviewNotification $notification) {
            $link = implode('/', [
                'shop/review-my-order',
                $this->order->reviewInvitation()->first()->id,
            ]);

            $this->assertStringContainsString($link, $notification->toMail($this->user)->render());

            return true;
        });
    }

    /** @test */
    public function itUpdatesTheSentColumn(): void
    {
        $invitation = $this->order->reviewInvitation()->create();

        $this->assertFalse($invitation->sent);

        Bus::dispatchNow(new SendReviewInvitation($this->order));

        $this->assertTrue($invitation->refresh()->sent);
    }

    /** @test */
    public function itUpdatesTheSentAtColumn(): void
    {
        $invitation = $this->order->reviewInvitation()->create();

        $this->assertNull($invitation->sent_at);

        Bus::dispatchNow(new SendReviewInvitation($this->order));

        $this->assertNotNull($invitation->refresh()->sent_at);
    }
}
