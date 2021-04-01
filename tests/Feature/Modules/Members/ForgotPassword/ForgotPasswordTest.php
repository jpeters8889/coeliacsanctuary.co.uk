<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Members\ForgotPassword;

use Coeliac\Modules\Member\Models\UserLevel;
use Tests\TestCase;
use Spatie\TestTime\TestTime;
use Coeliac\Modules\Member\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\Member\Notifications\ResetPassword;

class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        Notification::fake();
    }

    /** @test */
    public function itLoadsThePage()
    {
        $this->get('/member/forgot-password')
            ->assertStatus(200)
            ->assertSee('member-forgot-password-form');
    }

    /** @test */
    public function itErrorsWithoutAnEmail()
    {
        $this->post('/api/member/forgot-password')->assertStatus(422);
    }

    /** @test */
    public function itErrorsIfAUserIsLoggedIn()
    {
        $this->actingAs(factory(User::class)->create());

        $this->postJson('/api/member/forgot-password', ['email' => 'foo@bar.com'])->assertStatus(400);
    }

    /** @test */
    public function itDoesntSendANotificationIfTheUserDoesntExist()
    {
        $this->post('/api/member/forgot-password', [
            'email' => 'foo@bar.com',
        ])->assertStatus(400);

        Notification::assertNothingSent();

        $this->assertDatabaseCount('password_resets', 0);
    }

    /** @test */
    public function itErrorsIfTheUserIsntAnActiveMember()
    {
        $user = factory(User::class)->create([
            'email' => 'me@you.com',
            'user_level_id' => UserLevel::SHOP,
        ]);

        $this->post('/api/member/forgot-password', [
            'email' => $user->email,
        ])->assertStatus(400);

        Notification::assertNothingSent();

        $this->assertDatabaseCount('password_resets', 0);
    }

    /** @test */
    public function itSendsTheResetNotificationToAValidUser()
    {
        $user = factory(User::class)->create([
            'email' => 'me@you.com',
            'user_level_id' => UserLevel::MEMBER,
        ]);

        $this->post('/api/member/forgot-password', [
            'email' => $user->email,
        ])->assertOk();

        Notification::assertSentTo($user, ResetPassword::class);

        $this->assertDatabaseCount('password_resets', 1);
    }

    /** @test */
    public function itOnlyEverMakesOnePasswordRequestAtATime()
    {
        TestTime::freeze();

        $user = factory(User::class)->create([
            'email' => 'me@you.com',
            'user_level_id' => UserLevel::MEMBER,
        ]);

        $this->post('/api/member/forgot-password', [
            'email' => $user->email,
        ]);

        $this->assertDatabaseCount('password_resets', 1);

        TestTime::addMinutes(10);

        $this->post('/api/member/forgot-password', [
            'email' => $user->email,
        ]);

        $this->assertDatabaseCount('password_resets', 1);
    }
}
