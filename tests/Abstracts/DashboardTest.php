<?php

namespace Tests\Abstracts;

use Carbon\Carbon;
use Coeliac\Modules\Member\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

abstract class DashboardTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    abstract protected function page(): string;

    protected function mustBeVerified(): bool
    {
        return false;
    }

    protected function hasApiEndpoint(): bool
    {
        return true;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->actingAs($this->user);
    }

    /** @test */
    public function it_redirects_if_we_arent_signed_in()
    {
        $this->get('/member/logout');

        $this->makeRequest()->assertRedirect('/member/login');

        if($this->hasApiEndpoint()) {
            $this->makeApiRequest()->assertStatus(401);
        }
    }

    /** @test */
    public function it_errors_if_the_users_email_isnt_verified()
    {
        if (!$this->mustBeVerified()) {
            $this->assertTrue(true);
            return;
        }

        $this->user->update(['email_verified_at' => null]);

        $this->makeRequest()->assertSee('You need to verify your email address');

        if($this->hasApiEndpoint()) {
            $this->makeApiRequest()->assertStatus(403);
        }

        $this->user->update(['email_verified_at' => Carbon::now()]);
    }

    /** @test */
    public function it_redirects_ok_when_the_user_is_signed_in()
    {
        $this->makeRequest()->assertOk();
    }


    protected function makeRequest(): TestResponse
    {
        return $this->get("/member/dashboard/{$this->page()}");
    }

    protected function makeApiRequest(): TestResponse
    {
        return $this->getJson("/api/member/dashboard/{$this->page()}");
    }
}
