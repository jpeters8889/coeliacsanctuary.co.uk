<?php

namespace Tests\Unit;

use Coeliac\Modules\Member\Events\UserPasswordUpdated;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Notifications\PasswordChangedAlert;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

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
        Event::dispatch(new UserPasswordUpdated($this->user,));
    }

    /** @test */
    public function it_send_a_alert_to_the_user()
    {
        $this->dispatch();

        Notification::assertSentTo($this->user, PasswordChangedAlert::class);
    }
}
