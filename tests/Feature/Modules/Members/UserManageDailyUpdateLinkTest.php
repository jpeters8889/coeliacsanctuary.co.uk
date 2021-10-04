<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Members;

use Tests\TestCase;
use Spatie\TestTime\TestTime;
use Coeliac\Modules\Member\Models\User;

class UserManageDailyUpdateLinkTest extends TestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->create(User::class);

        TestTime::freeze();
    }

    /** @test */
    public function itCanGenerateAUrl()
    {
        $this->assertNotNull($this->user->generateManageDailyUpdatesLink());
    }

    /** @test */
    public function itRedirectsToTheMemberDailyUpdatesPage()
    {
        $this->get($this->user->generateManageDailyUpdatesLink())->assertRedirect('/member/dashboard/daily-updates');
    }

    /** @test */
    public function itLogsTheUserIn()
    {
        $this->assertFalse($this->isAuthenticated());

        $this->get($this->user->generateManageDailyUpdatesLink());

        $this->assertAuthenticatedAs($this->user);
    }

    /** @test */
    public function itDoesntLogInADifferentUser()
    {
        $user = $this->create(User::class);

        $this->actingAs($user);

        $this->get($this->user->generateManageDailyUpdatesLink());

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function itGeneratesALinkValidFor24Hours()
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
