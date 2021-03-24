<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Members\DailyUpdates;

use Tests\TestCase;
use Illuminate\Support\Str;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Blog\Models\BlogTag;
use Coeliac\Modules\Member\Models\DailyUpdateType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\Member\Models\UserDailyUpdateSubscription;

class SubscriptionsModelTest extends TestCase
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
    public function itCreatesAnUuidWhenCreating()
    {
        $this->assertNotNull($this->subscription->id);
        $this->assertTrue(Str::isUuid($this->subscription->id));
    }

    /** @test */
    public function itHasAccessToTheUser()
    {
        $this->assertNotNull($this->subscription->user);
        $this->assertTrue($this->user->is($this->subscription->user));
    }

    /** @test */
    public function itHasAccessToTheSubscriptionType()
    {
        $this->assertNotNull($this->subscription->type);
        $this->assertTrue($this->dailyUpdateType->is($this->subscription->type));
    }

    /** @test */
    public function itCanAccessTheSubscribable()
    {
        $this->assertNotNull($this->subscription->updatable);
        $this->assertTrue($this->updatable->is($this->subscription->updatable));
    }
}
