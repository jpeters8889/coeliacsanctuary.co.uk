<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Members\Dashboard;

use Tests\Abstracts\DashboardTest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\TestResponse;
use Illuminate\Support\Facades\Event;
use Coeliac\Modules\Member\Models\User;
use Illuminate\Support\Facades\Notification;
use Coeliac\Modules\Member\Events\UserEmailChanged;
use Coeliac\Modules\Member\Events\UserPasswordUpdated;

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
    public function itPassesTheUsersNameToTheVueComponent()
    {
        $this->makeRequest()->assertSee('name="'.$this->user->name.'"', false);
    }

    /** @test */
    public function itPassesTheUsersEmailToTheVueComponent()
    {
        $this->makeRequest()->assertSee('email="'.$this->user->email.'"', false);
    }

    /** @test */
    public function itPassesTheUsersPhoneToTheVueComponent()
    {
        $this->makeRequest()->assertSee('phone="'.$this->user->phone.'"', false);
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
    public function itErrorsWhenUpdatingWithoutAName()
    {
        $this->makeUpdateDetailsRequest(['name' => null])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenUpdatingWithoutAnEmail()
    {
        $this->makeUpdateDetailsRequest(['email' => null])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenUpdatingWithAnInvalidEmail()
    {
        $this->makeUpdateDetailsRequest(['email' => 'foo'])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenUpdatingToAnEmailAlreadyRegistered()
    {
        factory(User::class)->create(['email' => 'foo@bar.com']);

        $this->makeUpdateDetailsRequest(['email' => 'foo@bar.com'])->assertStatus(422);
    }

    /** @test */
    public function itReturnsOk()
    {
        $this->makeUpdateDetailsRequest()->assertOk();
    }

    /** @test */
    public function itUpdatesTheDatabase()
    {
        $this->makeUpdateDetailsRequest($params = [
           'name' => 'New Name',
           'email' => 'new@email.com',
           'phone' => '123456',
        ]);

        $this->user->refresh();

        foreach ($params as $key => $value) {
            $this->assertEquals($value, $this->user->$key);
        }
    }

    /** @test */
    public function itDispatchesAnEmailChangedEventWhenTheEmailIsChanged()
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
    public function itErrorsWhenUpdatingThePasswordWithoutTheCurrentPassword()
    {
        $this->makeUpdatePasswordRequest(['current' => null])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenUpdatingThePasswordWhenTheCurrentPasswordIsIncorrect()
    {
        $this->makeUpdatePasswordRequest(['current' => 'incorrect_password'])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenUpdatingThePasswordWithoutANewPassword()
    {
        $this->makeUpdatePasswordRequest(['new' => null])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenUpdatingThePasswordWhenTheNewPasswordIsTooShort()
    {
        $this->makeUpdatePasswordRequest(['new' => 'foo'])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenUpdatingThePasswordWhenTheNewPasswordIsntConfirmed()
    {
        $this->makeUpdatePasswordRequest(['new_confirmation' => null])->assertStatus(422);
    }

    /** @test */
    public function itReturnsOkWhenUpdatingThePassword()
    {
        Notification::fake();

        $this->makeUpdatePasswordRequest()->assertOk();
    }

    /** @test */
    public function itUpdatesThePassword()
    {
        $this->makeUpdatePasswordRequest();

        $this->assertTrue(Hash::check('new_password', $this->user->fresh()->password));
    }

    /** @test */
    public function itDispatchesAPasswordUpdatedEvent()
    {
        Event::fake();

        $this->makeUpdatePasswordRequest();

        Event::assertDispatched(UserPasswordUpdated::class);
    }
}
