<?php

namespace Tests\Unit;

use Coeliac\Modules\Blog\Models\BlogTag;
use Coeliac\Modules\Member\Models\DailyUpdateType;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\UserDailyUpdateSubscription;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DailyUpdatesTypeModelTest extends TestCase
{
    use RefreshDatabase;

    protected DailyUpdateType $dailyUpdateType;

    protected function setUp(): void
    {
        parent::setUp();

        $this->dailyUpdateType = factory(DailyUpdateType::class)->create();
    }

    /** @test */
    public function it_has_subscriptions()
    {
        $this->assertInstanceOf(HasMany::class, $this->dailyUpdateType->subscriptions());
        $this->assertEmpty($this->dailyUpdateType->subscriptions);

        $subscription = UserDailyUpdateSubscription::query()->create([
            'user_id' => factory(User::class)->create()->id,
            'daily_update_type_id' => $this->dailyUpdateType->id,
            'updatable_type' => BlogTag::class,
            'updatable_id' => 1,
        ]);

        $this->assertNotEmpty($this->dailyUpdateType->fresh()->subscriptions);
        $this->assertCount(1, $this->dailyUpdateType->fresh()->subscriptions);
        $this->assertTrue($subscription->is($this->dailyUpdateType->fresh()->subscriptions()->first()));
    }

    /** @test */
    public function it_can_be_subscriped_using_the_helper_method()
    {
        $this->assertEmpty($this->dailyUpdateType->subscriptions);

        $this->dailyUpdateType->subscribe(
            factory(User::class)->create(),
            factory(BlogTag::class)->create()
        );

        $this->assertNotEmpty($this->dailyUpdateType->fresh()->subscriptions);
        $this->assertCount(1, $this->dailyUpdateType->fresh()->subscriptions);
    }
}
