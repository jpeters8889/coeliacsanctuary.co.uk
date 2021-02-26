<?php

namespace Tests\Unit;

use Coeliac\Modules\Blog\Models\BlogTag;
use Coeliac\Modules\Member\Models\SubscriptionType;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\UserSubscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserSubscriptionModelTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected SubscriptionType $subscriptionType;
    protected BlogTag $subscribable;
    protected UserSubscription $subscription;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->subscriptionType = factory(SubscriptionType::class)->create();
        $this->subscribable = factory(BlogTag::class)->create();

        $this->subscription = UserSubscription::query()->create([
            'user_id' => $this->user->id,
            'user_subscription_type_id' => $this->subscriptionType->id,
            'subscribable_type' => get_class($this->subscribable),
            'subscribable_id' => $this->subscribable->id,
        ]);
    }

    /** @test */
    public function it_creates_an_uuid_when_creating()
    {
        $this->assertNotNull($this->subscription->id);
        $this->assertTrue(Str::isUuid($this->subscription->id));
    }

    /** @test */
    public function it_has_access_to_the_user()
    {
        $this->assertNotNull($this->subscription->user);
        $this->assertTrue($this->user->is($this->subscription->user));
    }

    /** @test */
    public function it_has_access_to_the_subscription_type()
    {
        $this->assertNotNull($this->subscription->type);
        $this->assertTrue($this->subscriptionType->is($this->subscription->type));
    }

    /** @test */
    public function it_can_access_the_subscribable()
    {
        $this->assertNotNull($this->subscription->subscribable);
        $this->assertTrue($this->subscribable->is($this->subscription->subscribable));
    }
}
