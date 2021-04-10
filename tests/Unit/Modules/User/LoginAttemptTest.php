<?php

namespace Tests\Unit\Modules\User;

use Coeliac\Modules\Member\Models\LoginAttempt;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginAttemptTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function itCanRecordAFailedLoginAttempt()
    {
        $this->assertEmpty(LoginAttempt::all());

        LoginAttempt::recordFailure(
            $this->faker->email,
            $this->faker->ipv4,
            'Test Failure',
        );

        $this->assertNotEmpty(LoginAttempt::all());

        /** @var LoginAttempt $log */
        $log = LoginAttempt::query()->first();

        $this->assertTrue($log->failed);
        $this->assertFalse($log->success);
        $this->assertNotNull($log->response);
    }

    /** @test */
    public function itCanRecordASuccessfulLoginAttempt()
    {
        $this->assertEmpty(LoginAttempt::all());

        LoginAttempt::recordSuccess(
            $this->faker->email,
            $this->faker->ipv4,
        );

        $this->assertNotEmpty(LoginAttempt::all());

        /** @var LoginAttempt $log */
        $log = LoginAttempt::query()->first();

        $this->assertTrue($log->success);
        $this->assertFalse($log->failed);
        $this->assertNull($log->response);
    }
}
