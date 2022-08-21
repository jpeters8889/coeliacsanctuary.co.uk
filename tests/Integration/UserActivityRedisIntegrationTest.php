<?php

declare(strict_types=1);

namespace Tests\Integration;

use Carbon\Carbon;
use Coeliac\Modules\Member\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\ParallelTesting;
use Illuminate\Support\Facades\Redis;
use Spatie\TestTime\TestTime;
use Tests\TestCase;
use Tests\Traits\InteractsWithRedis;

class UserActivityRedisIntegrationTest extends TestCase
{
    use InteractsWithRedis;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->markAsRisky();

        $this->setUpRedis();

        Redis::flushall();

        $this->user = $this->create(User::class, [
            'id' => ParallelTesting::token() ?: random_int(1, 10),
        ]);

        $this->actingAs($this->user);

        TestTime::freeze();
    }

    /** @test */
    public function itStoresTheUserIdAndCarbonTimeInARedisHashSetWhenAUserVisitsAPage()
    {
        $this->assertNull(Redis::hget('user.lastActivity', $this->user->id));

        $this->get('/');

        $this->assertNotNull(Redis::hget('user.lastActivity', $this->user->id));
        $this->assertEquals(
            Carbon::now()->format('Y-m-d H:i:s'),
            Redis::hget('user.lastActivity', $this->user->id),
        );

        TestTime::addHour();

        $this->get('/');

        $this->assertNotNull(Redis::hget('user.lastActivity', $this->user->id));
        $this->assertEquals(
            Carbon::now()->format('Y-m-d H:i:s'),
            Redis::hget('user.lastActivity', $this->user->id),
        );
    }

    /** @test */
    public function itDoesntStoreAnythingInRedisWhenTheUserIsLoggedOut()
    {
        Auth::logout();

        $this->assertNull(Redis::hget('user.lastActivity', $this->user->id));

        $this->get('/');

        $this->assertNull(Redis::hget('user.lastActivity', $this->user->id));
    }
}
