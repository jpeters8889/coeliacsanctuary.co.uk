<?php

namespace Tests\Unit;

use Coeliac\Modules\Blog\Models\BlogTag;
use Coeliac\Modules\Member\Models\SubscriptionType;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\UserSubscription;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriptionTypeModelTest extends TestCase
{
    use RefreshDatabase;

    protected SubscriptionType $subscriptionType;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subscriptionType = factory(SubscriptionType::class)->create();
    }

    /** @test */
    public function it_has_subscriptions()
    {
        $this->assertInstanceOf(HasMany::class, $this->subscriptionType->subscriptions());
        $this->assertEmpty($this->subscriptionType->subscriptions);

//        $this->subscriptionType->subscribe(
//            factory(User::class)->create(),
//            factory(BlogTag::class)->create()
//        );

        $subscription = UserSubscription::query()->create([
            'user_id' => factory(User::class)->create()->id,
            'user_subscription_type_id' => $this->subscriptionType->id,
            'subscribable_type' => BlogTag::class,
            'subscribable_id' => 1,
        ]);

        $this->assertNotEmpty($this->subscriptionType->fresh()->subscriptions);
        $this->assertCount(1, $this->subscriptionType->fresh()->subscriptions);
        $this->assertTrue($subscription->is($this->subscriptionType->fresh()->subscriptions()->first()));
    }

    /** @test */
    public function it_can_be_subscriped_using_the_helper_method()
    {
        $this->assertEmpty($this->subscriptionType->subscriptions);

        $this->subscriptionType->subscribe(
            factory(User::class)->create(),
            factory(BlogTag::class)->create()
        );

        $this->assertNotEmpty($this->subscriptionType->fresh()->subscriptions);
        $this->assertCount(1, $this->subscriptionType->fresh()->subscriptions);
    }
}
