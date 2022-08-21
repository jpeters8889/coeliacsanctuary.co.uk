<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Members;

use Coeliac\Modules\Member\Events\UserPasswordReset;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Notifications\PasswordResetAlert;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class UserPasswordUpdatedResetTest extends TestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->create(User::class);

        Notification::fake();
    }

    public function dispatch()
    {
        Event::dispatch(new UserPasswordReset($this->user, ));
    }

    /** @test */
    public function itSendAAlertToTheUser()
    {
        $this->dispatch();

        Notification::assertSentTo($this->user, PasswordResetAlert::class);
    }

    /** @test */
    public function itLogsThatThePasswordHasBeenUpdated()
    {
        $this->assertEmpty($this->user->passwordChanges);

        $this->dispatch();

        $this->assertNotEmpty($this->user->fresh()->passwordChanges);
    }
}
