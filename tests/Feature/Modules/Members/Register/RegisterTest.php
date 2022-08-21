<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Members\Register;

use Coeliac\Modules\Member\Events\UserRegistered;
use Coeliac\Modules\Member\Models\Scrapbook;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\UserLevel;
use Coeliac\Modules\Member\Notifications\VerifyEmail;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        User::query()->truncate();
    }

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
        $this->actingAs($this->create(User::class));

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
        $this->build(User::class)
            ->asMember()
            ->create([
                'email' => 'me@you.com',
            ]);

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
        $existingUser = $this->build(User::class)
            ->asShop()
            ->create();

        $this->assertCount(1, User::all());
        $this->assertNull($existingUser->password);

        $this->makeRegistrationRequest(['email' => $existingUser->email]);

        $this->assertCount(1, User::all());

        $this->assertEquals(UserLevel::MEMBER, $existingUser->fresh()->user_level_id);
        $this->assertNotNull($existingUser->fresh()->password);
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
