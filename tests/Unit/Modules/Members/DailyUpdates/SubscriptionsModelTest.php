<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Members\DailyUpdates;

use Tests\TestCase;
use Illuminate\Support\Str;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Blog\Models\BlogTag;
use Coeliac\Modules\Member\Models\DailyUpdateType;
use Coeliac\Modules\Member\Models\UserDailyUpdateSubscription;

class SubscriptionsModelTest extends TestCase
{
    protected User $user;
    protected DailyUpdateType $dailyUpdateType;
    protected BlogTag $updatable;
    protected UserDailyUpdateSubscription $subscription;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->create(User::class);
        $this->dailyUpdateType = DailyUpdateType::query()->first();
        $this->updatable = $this->create(BlogTag::class);

        $this->subscription = $this->build(UserDailyUpdateSubscription::class)
            ->on($this->updatable)
            ->forUser($this->user)
            ->create();
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
