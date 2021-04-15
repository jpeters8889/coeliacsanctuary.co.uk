<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Members\Login;

use Carbon\Carbon;
use Tests\TestCase;
use Tests\Traits\CreateUser;
use Spatie\TestTime\TestTime;
use Illuminate\Support\Facades\Auth;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\UserLevel;
use Coeliac\Modules\Member\Models\LoginAttempt;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    use CreateUser;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser([
            'email' => 'me@you.com',
            'user_level_id' => UserLevel::MEMBER,
        ]);
    }

    /** @test */
    public function itLoadsTheLoginPage()
    {
        $this->get('/member/login')
            ->assertStatus(200)
            ->assertSee('<member-login-form>', false);
    }

    /** @test */
    public function itDoesntLoadThePageIfLoggedIn()
    {
        $this->actingAs($this->user);

        $this->get('/member/login')->assertRedirect('/member/dashboard');
    }

    protected function makeLoginRequest($email = null, $password = null)
    {
        return $this->post('/api/member/login', [
            'email' => $email ?? $this->user->email,
            'password' => $password ?? 'password',
        ]);
    }

    /** @test */
    public function itErrorsIfWeDontHaveAnEmail()
    {
        $this->makeLoginRequest('')->assertStatus(422);
    }

    /** @test */
    public function itErrorsIfWePassAnInvalidEmail()
    {
        $this->makeLoginRequest('foo')->assertStatus(422);
    }

    /** @test */
    public function itErrorsIfWeDontHaveAPassword()
    {
        $this->makeLoginRequest(null, '')->assertStatus(422);
    }

    /** @test */
    public function itErrorsIfTheEmailDoesntExist()
    {
        $this->makeLoginRequest('foo@bar.com')->assertStatus(422);
    }

    /** @test */
    public function itErrorsIfTheUserIsntActive()
    {
        $this->user->update(['user_level_id' => UserLevel::SHOP]);

        $this->makeLoginRequest()->assertStatus(422);
    }

    /** @test */
    public function itErrorsIfThePasswordIsWrong()
    {
        $this->makeLoginRequest(null, 'foo')->assertStatus(422);
    }

    /** @test */
    public function itReturnsOkWithValidData()
    {
        $this->makeLoginRequest()->assertOk();
    }

    /** @test */
    public function itLogsTheUserIn()
    {
        $this->assertFalse($this->isAuthenticated());

        $this->makeLoginRequest();

        $this->assertAuthenticatedAs($this->user);
    }

    /** @test */
    public function itCanLogAFailedLogin()
    {
        $this->assertEmpty(LoginAttempt::all());

        $this->user->update(['user_level_id' => UserLevel::SHOP]);

        $this->makeLoginRequest();

        $this->assertNotEmpty(LoginAttempt::all());

        $this->assertTrue(LoginAttempt::query()->first()->failed);
    }

    /** @test */
    public function itCorrectlyLogsValidationErrors()
    {
        $this->makeLoginRequest(null, 'asf', 'afasfasf');

        $this->assertNotEmpty(LoginAttempt::all());

        /** @var LoginAttempt $log */
        $log = LoginAttempt::query()->first();

        $this->assertEquals('Unknown error', $log->response);
    }

    /** @test */
    public function itCorrectlyLogsWhenTheUserDoesntExist()
    {
        $this->makeLoginRequest('foo@bar.com');

        $this->assertNotEmpty(LoginAttempt::all());

        /** @var LoginAttempt $log */
        $log = LoginAttempt::query()->first();

        $this->assertEquals("User doesn't exist", $log->response);
    }

    /** @test */
    public function itCorrectyLogsWhenAShopUserAttemptsToLogin()
    {
        $this->user->update(['user_level_id' => UserLevel::SHOP]);

        $this->makeLoginRequest();

        $this->assertNotEmpty(LoginAttempt::all());

        /** @var LoginAttempt $log */
        $log = LoginAttempt::query()->first();

        $this->assertEquals('User is shop user only', $log->response);
    }

    /** @test */
    public function itLogsASuccessfulLogin()
    {
        $this->assertEmpty(LoginAttempt::all());

        $this->makeLoginRequest();

        $this->assertNotEmpty(LoginAttempt::all());

        $this->assertTrue(LoginAttempt::query()->first()->success);
    }

    /** @test */
    public function itMarksTheUsersLastLoginTime()
    {
        TestTime::freeze();

        $this->assertNull($this->user->last_logged_in_at);

        $this->makeLoginRequest();

        $this->assertNotNull($this->user->refresh()->last_logged_in_at);
        $this->assertEquals(Carbon::now()->toString(), $this->user->last_logged_in_at->toString());

        Auth::logout();

        TestTime::addWeek();

        $this->makeLoginRequest();

        $this->assertEquals(Carbon::now()->toString(), $this->user->refresh()->last_logged_in_at->toString());
    }
}
