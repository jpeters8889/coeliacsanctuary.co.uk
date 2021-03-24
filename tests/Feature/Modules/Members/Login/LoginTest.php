<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Members\Login;

use Tests\TestCase;
use Tests\Traits\CreateUser;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\UserLevel;
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
}
