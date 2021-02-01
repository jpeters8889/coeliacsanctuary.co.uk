<?php

declare(strict_types=1);

namespace Tests\Feature;

use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\UserLevel;
use Tests\TestCase;
use Tests\Traits\CreateUser;
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
            'user_level_id' => UserLevel::MEMBER
        ]);
    }

    /** @test */
    public function it_loads_the_login_page()
    {
        $this->get('/member/login')
            ->assertStatus(200)
            ->assertSee('<login-form>', false);
    }

    protected function makeLoginRequest($email = null, $password = null)
    {
        return $this->post('/api/members/login', [
            'email' => $email ?? $this->user->email,
            'password' => $password ?? 'password',
        ]);
    }

    /** @test */
    public function it_errors_if_we_dont_have_an_email()
    {
        $this->makeLoginRequest('')->assertStatus(422);
    }

    /** @test */
    public function it_errors_if_we_pass_an_invalid_email()
    {
        $this->makeLoginRequest('foo')->assertStatus(422);
    }

    /** @test */
    public function it_errors_if_we_dont_have_a_password()
    {
        $this->makeLoginRequest(null, '')->assertStatus(422);
    }

    /** @test */
    public function it_errors_if_the_email_doesnt_exist()
    {
        $this->makeLoginRequest('foo@bar.com')->assertStatus(422);
    }

    /** @test */
    public function it_errors_if_the_user_isnt_active()
    {
        $this->user->update(['user_level_id' => UserLevel::SHOP]);

        $this->makeLoginRequest()->assertStatus(422);
    }

    /** @test */
    public function it_errors_if_the_user_is_inactive()
    {
        $this->user->update(['email_verified_at' => null]);

        $this->makeLoginRequest()->assertStatus(422)->assertJsonFragment([
            'message' => 'email not verified',
        ]);
    }

    /** @test */
    public function it_errors_if_the_password_is_wrong()
    {
        $this->makeLoginRequest(null, 'foo')->assertStatus(422);
    }

    /** @test */
    public function it_returns_ok_with_valid_data()
    {
        $this->makeLoginRequest()->assertOk();
    }

    /** @test */
    public function it_logs_the_user_in()
    {
        $this->assertFalse($this->isAuthenticated());

        $this->makeLoginRequest();

        $this->assertAuthenticatedAs($this->user);
    }
}
