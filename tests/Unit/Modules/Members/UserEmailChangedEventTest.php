<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Members;

use Tests\TestCase;
use Illuminate\Support\Facades\Event;
use Coeliac\Modules\Member\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\AnonymousNotifiable;
use Coeliac\Modules\Member\Events\UserEmailChanged;
use Coeliac\Modules\Member\Notifications\VerifyEmail;
use Coeliac\Modules\Member\Notifications\EmailChangedAlert;

class UserEmailChangedEventTest extends TestCase
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
        Event::dispatch(new UserEmailChanged($this->user, 'old@email.com'));
    }

    /** @test */
    public function itMarksTheEmailAsNotVerified()
    {
        $this->assertTrue($this->user->hasVerifiedEmail());

        $this->dispatch();

        $this->assertFalse($this->user->fresh()->hasVerifiedEmail());
    }

    /** @test */
    public function itAlertsTheOldEmailAddressThatTheirEmailHasBeenChanged()
    {
        $this->dispatch();

        Notification::assertSentTo(
            new AnonymousNotifiable(),
            EmailChangedAlert::class,
            function (EmailChangedAlert $notification, $channels, AnonymousNotifiable $notifiable) {
                return $notifiable->routes['mail'] === 'old@email.com';
            },
        );
    }

    /** @test */
    public function itSendAVerificationEmailToTheNewEmail()
    {
        $this->dispatch();

        Notification::assertSentTo($this->user, VerifyEmail::class);
    }
}
