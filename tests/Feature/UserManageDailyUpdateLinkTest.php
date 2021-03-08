<?php

declare(strict_types=1);

namespace Tests\Feature;

use Spatie\TestTime\TestTime;
use Tests\TestCase;
use Coeliac\Modules\Member\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserManageDailyUpdateLinkTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        TestTime::freeze();
    }

    /** @test */
    public function it_can_generate_a_url()
    {
        $this->assertNotNull($this->user->generateManageDailyUpdatesLink());
    }

    /** @test */
    public function it_redirects_to_the_member_daily_updates_page()
    {
        $this->get($this->user->generateManageDailyUpdatesLink())->assertRedirect('/member/dashboard/daily-updates');
    }

    /** @test */
    public function it_logs_the_user_in()
    {
        $this->assertFalse($this->isAuthenticated());

        $this->get($this->user->generateManageDailyUpdatesLink());

        $this->assertAuthenticatedAs($this->user);
    }

    /** @test */
    public function it_doesnt_log_in_a_different_user()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $this->get($this->user->generateManageDailyUpdatesLink());

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function it_generates_a_link_valid_for_24_hours()
    {
        $link = $this->user->generateManageDailyUpdatesLink();

        $this->get($link)->assertRedirect();

        TestTime::addHours(12);

        $this->get($link)->assertRedirect();

        TestTime::addHours(12);

        $this->get($link)->assertRedirect();

        TestTime::addMinute();

        $this->get($link)->assertStatus(403);
    }
}
