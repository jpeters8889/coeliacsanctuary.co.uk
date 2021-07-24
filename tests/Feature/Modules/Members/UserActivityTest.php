<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Members;

use Carbon\Carbon;
use Tests\TestCase;
use Tests\Traits\CreateUser;
use Spatie\TestTime\TestTime;
use Tests\Mocks\UserActivityMock;
use Illuminate\Support\Facades\Auth;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\UserLevel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\Member\Contracts\UserActivityMonitor;

class UserActivityTest extends TestCase
{
    use RefreshDatabase;
    use CreateUser;

    protected User $user;
    protected UserActivityMonitor $activityMonitor;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->instance(UserActivityMonitor::class, new UserActivityMock());

        $this->user = $this->createUser([
            'email' => 'me@you.com',
            'user_level_id' => UserLevel::MEMBER,
        ]);

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
