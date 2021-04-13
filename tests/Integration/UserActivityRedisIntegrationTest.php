<?php

declare(strict_types=1);

namespace Tests\Integration;

use Carbon\Carbon;
use Tests\TestCase;
use Tests\Traits\CreateUser;
use Spatie\TestTime\TestTime;
use Illuminate\Support\Facades\Auth;
use Tests\Traits\InteractsWithRedis;
use Illuminate\Support\Facades\Redis;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\UserLevel;
use Illuminate\Support\Facades\ParallelTesting;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserActivityRedisIntegrationTest extends TestCase
{
    use RefreshDatabase;
    use RefreshDatabase;
    use CreateUser;
    use InteractsWithRedis;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->markAsRisky();

        $this->setUpRedis();

        Redis::flushall();

        $this->user = $this->createUser([
            'id' => ParallelTesting::token() ?: 1,
            'email' => 'me@you.com',
            'user_level_id' => UserLevel::MEMBER,
        ]);

        $this->actingAs($this->user);

        TestTime::freeze();
    }

    /** @test */
    public function itStoresTheUserIdAndCarbonTimeInARedisHashSetWhenAUserVisitsAPage()
    {
        $this->assertNull(Redis::hget('user.lastActivity', ParallelTesting::token() ?: 1));

        $this->get('/');

        $this->assertNotNull(Redis::hget('user.lastActivity', ParallelTesting::token() ?: 1));
        $this->assertEquals(
            Carbon::now()->format('Y-m-d H:i:s'),
            Redis::hget('user.lastActivity', ParallelTesting::token() ?: 1),
        );

        TestTime::addHour();

        $this->get('/');

        $this->assertNotNull(Redis::hget('user.lastActivity', ParallelTesting::token() ?: 1));
        $this->assertEquals(
            Carbon::now()->format('Y-m-d H:i:s'),
            Redis::hget('user.lastActivity', ParallelTesting::token() ?: 1),
        );
    }

    /** @test */
    public function itDoesntStoreAnythingInRedisWhenTheUserIsLoggedOut()
    {
        Auth::logout();

        $this->assertNull(Redis::hget('user.lastActivity', ParallelTesting::token() ?: 1));

        $this->get('/');

        $this->assertNull(Redis::hget('user.lastActivity', ParallelTesting::token() ?: 1));
    }
}
