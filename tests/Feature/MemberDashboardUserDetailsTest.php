<?php

namespace Tests\Feature;

use Coeliac\Modules\Member\Events\UserEmailChanged;
use Coeliac\Modules\Member\Events\UserPasswordUpdated;
use Coeliac\Modules\Member\Models\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Testing\TestResponse;
use Tests\Abstracts\DashboardTest;

class MemberDashboardUserDetailsTest extends DashboardTest
{
    protected function mustBeVerified(): bool
    {
        return false;
    }

    protected function hasApiEndpoint(): bool
    {
        return false;
    }

    protected function page(): string
    {
        return 'details';
    }

    /** @test */
    public function it_passes_the_users_name_to_the_vue_component()
    {
        $this->makeRequest()->assertSee('name="' . $this->user->name . '"', false);
    }

    /** @test */
    public function it_passes_the_users_email_to_the_vue_component()
    {
        $this->makeRequest()->assertSee('email="' . $this->user->email . '"', false);
    }

    /** @test */
    public function it_passes_the_users_phone_to_the_vue_component()
    {
        $this->makeRequest()->assertSee('phone="' . $this->user->phone . '"', false);
    }

    protected function makeUpdateDetailsRequest($params = []): TestResponse
    {
        return $this->post('/api/member/dashboard/details', array_merge([
            'name' => $this->user->name,
            'email' => $this->user->email,
            'phone' => $this->user->phone,
        ], $params));
    }

    /** @test */
    public function it_errors_when_updating_without_a_name()
    {
        $this->makeUpdateDetailsRequest(['name' => null])->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_updating_without_an_email()
    {
        $this->makeUpdateDetailsRequest(['email' => null])->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_updating_with_an_invalid_email()
    {
        $this->makeUpdateDetailsRequest(['email' => 'foo'])->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_updating_to_an_email_already_registered()
    {
        factory(User::class)->create(['email' => 'foo@bar.com']);

        $this->makeUpdateDetailsRequest(['email' => 'foo@bar.com'])->assertStatus(422);
    }

    /** @test */
    public function it_returns_ok()
    {
        $this->makeUpdateDetailsRequest()->assertOk();
    }

    /** @test */
    public function it_updates_the_database()
    {
        $this->makeUpdateDetailsRequest($params = [
           'name' => 'New Name',
           'email' => 'new@email.com',
           'phone' => '123456',
        ]);

        $this->user->refresh();

        foreach($params as $key => $value) {
            $this->assertEquals($value, $this->user->$key);
        }
    }

    /** @test */
    public function it_dispatches_an_email_changed_event_when_the_email_is_changed()
    {
        Event::fake();

        $this->makeUpdateDetailsRequest();
        Event::assertNotDispatched(UserEmailChanged::class);

        $this->makeUpdateDetailsRequest(['email' => 'new@email.com']);
        Event::assertDispatched(UserEmailChanged::class);
    }

    protected function makeUpdatePasswordRequest($params = []): TestResponse
    {
        return $this->patch('/api/member/dashboard/details', array_merge([
            'current' => 'password',
            'new' => 'new_password',
            'new_confirmation' => 'new_password',
        ], $params));
    }

    /** @test */
    public function it_errors_when_updating_the_password_without_the_current_password()
    {
        $this->makeUpdatePasswordRequest(['current' => null])->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_updating_the_password_when_the_current_password_is_incorrect()
    {
        $this->makeUpdatePasswordRequest(['current' => 'incorrect_password'])->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_updating_the_password_without_a_new_password()
    {
        $this->makeUpdatePasswordRequest(['new' => null])->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_updating_the_password_when_the_new_password_is_too_short()
    {
        $this->makeUpdatePasswordRequest(['new' => 'foo'])->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_updating_the_password_when_the_new_password_isnt_confirmed()
    {
        $this->makeUpdatePasswordRequest(['new_confirmation' => null])->assertStatus(422);
    }

    /** @test */
    public function it_returns_ok_when_updating_the_password()
    {
        Notification::fake();

        $this->makeUpdatePasswordRequest()->assertOk();
    }

    /** @test */
    public function it_updates_the_password()
    {
        $this->makeUpdatePasswordRequest();

        $this->assertTrue(Hash::check('new_password', $this->user->fresh()->password));
    }

    /** @test */
    public function it_dispatches_a_password_updated_event()
    {
        Event::fake();

        $this->makeUpdatePasswordRequest();

        Event::assertDispatched(UserPasswordUpdated::class);
    }
}
