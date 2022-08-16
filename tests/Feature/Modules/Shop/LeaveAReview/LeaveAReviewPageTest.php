<?php

namespace Tests\Feature\Modules\Shop\LeaveAReview;

use Carbon\Carbon;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\UserAddress;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopOrderItem;
use Coeliac\Modules\Shop\Models\ShopOrderReviewInvitation;
use Coeliac\Modules\Shop\Models\ShopPayment;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Coeliac\Modules\Shop\Models\ShopProductVariant;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class LeaveAReviewPageTest extends TestCase
{
    protected User $user;
    protected ShopOrder $order;
    protected ShopOrderReviewInvitation $invitation;

    protected function setUp(): void
    {
        parent::setUp();

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

        $this->invitation = $this->order->reviewInvitation()->create();
    }

    /** @test */
    public function itReturnsNotFoundIfVisitingAnInvitationThatDoesntExist(): void
    {
        $this->get('/shop/review-my-order/foo-bar')->assertNotFound();
    }

    /** @test */
    public function itErrorsWhenVisitingTheInvitationDirectly(): void
    {
        $this->get("/shop/review-my-order/{$this->invitation->id}")->assertForbidden();
    }

    /** @test */
    public function itReturnsOkWhenVisitingAValidInvitation(): void
    {
        $this->getSignedLink()->assertOk();
    }

    /** @test */
    public function itErrorsIfTheInvitationHasAReviewAssociatedWithIt(): void
    {
        $this->invitation->review()->create(['order_id' => $this->order->id, 'name' => 'Foo']);

        $this->getSignedLink()->assertNotFound();
    }

    protected function getSignedLink(): TestResponse
    {
        return $this->get(resolve(UrlGenerator::class)->temporarySignedRoute(
            'shop.review-order',
            Carbon::now()->addMonths(6),
            [
                'invitation' => $this->invitation,
                'hash' => sha1($this->user->email),
            ]
        ));
    }
}
