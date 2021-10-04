<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Members\DailyUpdates;

use Tests\TestCase;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Blog\Models\BlogTag;
use Coeliac\Modules\Member\Models\DailyUpdateType;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Coeliac\Modules\Member\Models\UserDailyUpdateSubscription;

class DailyUpdatesTypeModelTest extends TestCase
{
    protected DailyUpdateType $dailyUpdateType;

    protected function setUp(): void
    {
        parent::setUp();

        $this->dailyUpdateType = DailyUpdateType::query()->firstWhere('name', 'Blog Tags');
    }

    /** @test */
    public function itHasSubscriptions()
    {
        $this->assertInstanceOf(HasMany::class, $this->dailyUpdateType->subscriptions());
        $this->assertEmpty($this->dailyUpdateType->subscriptions);

        $subscription = $this->create(UserDailyUpdateSubscription::class);

        $this->assertNotEmpty($this->dailyUpdateType->fresh()->subscriptions);
        $this->assertCount(1, $this->dailyUpdateType->fresh()->subscriptions);
        $this->assertTrue($subscription->is($this->dailyUpdateType->fresh()->subscriptions()->first()));
    }

    /** @test */
    public function itCanBeSubscripedUsingTheHelperMethod()
    {
        $this->assertEmpty($this->dailyUpdateType->subscriptions);

        $this->dailyUpdateType->subscribe(
            $this->create(User::class),
            $this->create(BlogTag::class)
        );

        $this->assertNotEmpty($this->dailyUpdateType->fresh()->subscriptions);
        $this->assertCount(1, $this->dailyUpdateType->fresh()->subscriptions);
    }
}
