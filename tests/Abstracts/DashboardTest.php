<?php

declare(strict_types=1);

namespace Tests\Abstracts;

use Carbon\Carbon;
use Coeliac\Modules\Member\Models\User;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

abstract class DashboardTest extends TestCase
{
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

        $this->user = $this->create(User::class);
        $this->actingAs($this->user);
    }

    /** @test */
    public function itRedirectsIfWeArentSignedIn()
    {
        $this->get('/member/logout');

        $this->makeRequest()->assertRedirect('/member/login');

        if ($this->hasApiEndpoint()) {
            $this->makeApiRequest()->assertStatus(401);
        }
    }

    /** @test */
    public function itErrorsIfTheUsersEmailIsntVerified()
    {
        if (! $this->mustBeVerified()) {
            $this->assertTrue(true);

            return;
        }

        $this->user->update(['email_verified_at' => null]);

        $this->makeRequest()->assertSee('You need to verify your email address');

        if ($this->hasApiEndpoint()) {
            $this->makeApiRequest()->assertStatus(403);
        }

        $this->user->update(['email_verified_at' => Carbon::now()]);
    }

    /** @test */
    public function itReturnsOkWhenTheUserIsSignedIn()
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
