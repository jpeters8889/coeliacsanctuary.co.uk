<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Members\Register;

use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Event;
use Coeliac\Modules\Member\Models\User;
use Illuminate\Contracts\Hashing\Hasher;
use Coeliac\Modules\Member\Models\Scrapbook;
use Coeliac\Modules\Member\Models\UserLevel;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Coeliac\Modules\Member\Events\UserRegistered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\Member\Notifications\VerifyEmail;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function itLoadsTheRegisterPage()
    {
        $this->get('/member/register')
            ->assertStatus(200)
            ->assertSee('<member-register-form>', false);
    }

    /** @test */
    public function itRedirectsToTheDashboardIfTheUserIsLoggedIn()
    {
        $this->actingAs(factory(User::class)->create());

        $this->get('/member/register')
            ->assertRedirect('/member/dashboard');
    }

    protected function makeRegistrationRequest($params = [])
    {
        Notification::fake();

        return $this->post('/api/member/register', array_merge([
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => 'password',
            'password_confirmation' => 'password',
            'terms' => true,
        ], $params));
    }

    /** @test */
    public function itErrorsWithoutAName()
    {
        $this->makeRegistrationRequest(['name' => null])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWithoutAnEmail()
    {
        $this->makeRegistrationRequest(['email' => null])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWithAnInvalidEmail()
    {
        $this->makeRegistrationRequest(['email' => 'foo'])->assertStatus(422);
    }

    /** @test */
    public function itErrorsIfTheEmailAlreadyExists()
    {
        factory(User::class)->create(['email' => 'me@you.com', 'user_level_id' => UserLevel::MEMBER]);

        $this->makeRegistrationRequest(['email' => 'me@you.com'])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWithoutAPassword()
    {
        $this->makeRegistrationRequest(['password' => null])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWithAPasswordThatIsTooShort()
    {
        $this->makeRegistrationRequest(['password' => Str::random(7)])
            ->assertStatus(422);
    }

    /** @test */
    public function itErrorsWithoutAPasswordConfirmation()
    {
        $this->makeRegistrationRequest(['password_confirmation' => null])->assertStatus(422);
    }

    /** @test */
    public function itErrorsIfThePasswordsDoNotMatch()
    {
        $this->makeRegistrationRequest([
            'password' => 'password',
            'password_confirmation' => 'password2',
        ])->assertStatus(422);
    }

    /** @test */
    public function itErrorsIfTheTermsArentAccepted()
    {
        $this->makeRegistrationRequest(['terms' => false])->assertStatus(422);
    }

    /** @test */
    public function itCreatesTheUser()
    {
        $this->assertEmpty(User::all());

        $this->makeRegistrationRequest([
           'name' => 'jamie peters',
           'email' => 'me@you.com',
        ]);

        $this->assertCount(1, User::all());

        $user = User::query()->first();

        $this->assertEquals('jamie peters', $user->name);
        $this->assertEquals('me@you.com', $user->email);
        $this->assertEquals(UserLevel::MEMBER, $user->user_level_id);
    }

    /** @test */
    public function itHashesThePassword()
    {
        $this->makeRegistrationRequest([
            'name' => 'jamie peters',
            'email' => 'me@you.com',
            'password' => 'my_password',
            'password_confirmation' => 'my_password',
        ]);

        $user = User::query()->first();

        /** @var Hasher $hasher */
        $hasher = resolve(Hasher::class);

        $this->assertTrue($hasher->check('my_password', $user->password));
    }

    /** @test */
    public function itAttachesToAnExistingInactiveShopPurchaser()
    {
        $this->withoutExceptionHandling();

        $existingUser = factory(User::class)->create(['user_level_id' => UserLevel::SHOP]);

        $this->assertCount(1, User::all());

        $this->makeRegistrationRequest(['email' => $existingUser->email]);

        $this->assertCount(1, User::all());

        $this->assertEquals(UserLevel::MEMBER, $existingUser->fresh()->user_level_id);
    }

    /** @test */
    public function itDispatchesTheUserRegisteredEvent()
    {
        Event::fake();

        $this->makeRegistrationRequest();

        Event::assertDispatched(UserRegistered::class);
    }

    /** @test */
    public function itCreatesADefaultScrapbookForTheUser()
    {
        $this->assertEmpty(Scrapbook::all());

        $this->makeRegistrationRequest();

        $this->assertNotEmpty(Scrapbook::all());

        $this->assertCount(1, User::query()->first()->scrapbooks);
    }

    /** @test */
    public function itSendsTheVerifyEmailNotification()
    {
        $this->makeRegistrationRequest();

        Notification::assertSentTo(
            User::query()->first(),
            VerifyEmail::class,
        );
    }

    /** @test */
    public function itLogsTheUserInAndRedirectsToTheDashboardAfterASuccessfulRegistration()
    {
        $this->assertFalse($this->isAuthenticated());

        $this->makeRegistrationRequest()->assertRedirect('/member/dashboard');

        $this->assertAuthenticatedAs(User::query()->first());
    }
}
