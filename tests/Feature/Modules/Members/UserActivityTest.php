<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Members;

use Carbon\Carbon;
use Coeliac\Modules\Member\Contracts\UserActivityMonitor;
use Coeliac\Modules\Member\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\TestTime\TestTime;
use Tests\Mocks\UserActivityMock;
use Tests\TestCase;

class UserActivityTest extends TestCase
{
    protected User $user;
    protected UserActivityMonitor $activityMonitor;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->instance(UserActivityMonitor::class, new UserActivityMock());

        $this->user = $this->build(User::class)
            ->asMember()
            ->create();

        $this->actingAs($this->user);

        TestTime::freeze();

        $this->activityMonitor = app(UserActivityMonitor::class);
    }

    /** @test */
    public function itLogsWhenTheUserLastVisitsAPage()
    {
        $this->assertNull($this->activityMonitor->lastVisitForUser($this->user));

        $this->get('/');

        $this->assertNotNull($lastVisit = $this->activityMonitor->lastVisitForUser($this->user));
        $this->assertEquals(Carbon::now()->format('Y-m-d H:i:s'), $lastVisit);

        TestTime::addHour();

        $this->get('/');

        $this->assertNotNull($lastVisit = $this->activityMonitor->lastVisitForUser($this->user));
        $this->assertEquals(Carbon::now()->format('Y-m-d H:i:s'), $lastVisit);
    }

    /** @test */
    public function itDoesntLogAnythingWhenTheUserIsLoggedOut()
    {
        Auth::logout();

        $this->assertNull($this->activityMonitor->lastVisitForUser($this->user));

        $this->get('/');

        $this->assertNull($this->activityMonitor->lastVisitForUser($this->user));
    }
}
