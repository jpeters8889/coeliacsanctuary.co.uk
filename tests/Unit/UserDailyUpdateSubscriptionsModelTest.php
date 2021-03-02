<?php

namespace Tests\Unit;

use Coeliac\Modules\Blog\Models\BlogTag;
use Coeliac\Modules\Member\Models\DailyUpdateType;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\UserDailyUpdateSubscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserDailyUpdateSubscriptionsModelTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected DailyUpdateType $dailyUpdateType;
    protected BlogTag $updatable;
    protected UserDailyUpdateSubscription $subscription;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->dailyUpdateType = factory(DailyUpdateType::class)->create();
        $this->updatable = factory(BlogTag::class)->create();

        $this->subscription = UserDailyUpdateSubscription::query()->create([
            'user_id' => $this->user->id,
            'daily_update_type_id' => $this->dailyUpdateType->id,
            'updatable_type' => get_class($this->updatable),
            'updatable_id' => $this->updatable->id,
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
        $this->assertTrue($this->dailyUpdateType->is($this->subscription->type));
    }

    /** @test */
    public function it_can_access_the_subscribable()
    {
        $this->assertNotNull($this->subscription->updatable);
        $this->assertTrue($this->updatable->is($this->subscription->updatable));
    }
}
