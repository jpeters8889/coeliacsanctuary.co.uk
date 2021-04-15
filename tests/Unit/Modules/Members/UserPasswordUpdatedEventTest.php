<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Members;

use Tests\TestCase;
use Illuminate\Support\Facades\Event;
use Coeliac\Modules\Member\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\Member\Events\UserPasswordUpdated;
use Coeliac\Modules\Member\Notifications\PasswordChangedAlert;

class UserPasswordUpdatedEventTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        Notification::fake();
    }

    public function dispatch()
    {
        Event::dispatch(new UserPasswordUpdated($this->user, ));
    }

    /** @test */
    public function itSendAAlertToTheUser()
    {
        $this->dispatch();

        Notification::assertSentTo($this->user, PasswordChangedAlert::class);
    }

    /** @test */
    public function itLogsThatThePasswordHasBeenUpdated()
    {
        $this->assertEmpty($this->user->passwordChanges);

        $this->dispatch();

        $this->assertNotEmpty($this->user->fresh()->passwordChanges);
    }
}
