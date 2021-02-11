<?php

namespace Tests\Unit;

use Coeliac\Modules\Member\Events\UserEmailChanged;
use Coeliac\Modules\Member\Listeners\SendEmailUpdatedVerificationEmail;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Notifications\EmailChangedAlert;
use Coeliac\Modules\Member\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class UserEmailChangedEventTest extends TestCase
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
        Event::dispatch(new UserEmailChanged($this->user, 'old@email.com'));
    }

    /** @test */
    public function it_marks_the_email_as_not_verified()
    {
        $this->assertTrue($this->user->hasVerifiedEmail());

        $this->dispatch();

        $this->assertFalse($this->user->fresh()->hasVerifiedEmail());
    }

    /** @test */
    public function it_alerts_the_old_email_address_that_their_email_has_been_changed()
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
    public function it_send_a_verification_email_to_the_new_email()
    {
        $this->dispatch();

        Notification::assertSentTo($this->user, VerifyEmail::class);
    }
}
