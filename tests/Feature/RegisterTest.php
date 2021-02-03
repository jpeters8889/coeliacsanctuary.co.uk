<?php

declare(strict_types=1);

namespace Tests\Feature;

use Coeliac\Modules\Member\Events\UserRegistered;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\UserLevel;
use Coeliac\Modules\Member\Notifications\VerifyEmail;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function it_loads_the_register_page()
    {
        $this->get('/member/register')
            ->assertStatus(200)
            ->assertSee('<register-form>', false);
    }

    /** @test */
    public function it_redirects_to_the_dashboard_if_the_user_is_logged_in()
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
    public function it_errors_without_a_name()
    {
        $this->makeRegistrationRequest(['name' => null])->assertStatus(422);
    }

    /** @test */
    public function it_errors_without_an_email()
    {
        $this->makeRegistrationRequest(['email' => null])->assertStatus(422);
    }

    /** @test */
    public function it_errors_with_an_invalid_email()
    {
        $this->makeRegistrationRequest(['email' => 'foo'])->assertStatus(422);
    }

    /** @test */
    public function it_errors_if_the_email_already_exists()
    {
        factory(User::class)->create(['email' => 'me@you.com', 'user_level_id' => UserLevel::MEMBER]);

        $this->makeRegistrationRequest(['email' => 'me@you.com'])->assertStatus(422);
    }

    /** @test */
    public function it_errors_without_a_password()
    {
        $this->makeRegistrationRequest(['password' => null])->assertStatus(422);
    }

    /** @test */
    public function it_errors_with_a_password_that_is_too_short()
    {
        $this->makeRegistrationRequest(['password' => Str::random(7)])
            ->assertStatus(422);
    }

    /** @test */
    public function it_errors_without_a_password_confirmation()
    {
        $this->makeRegistrationRequest(['password_confirmation' => null])->assertStatus(422);
    }

    /** @test */
    public function it_errors_if_the_passwords_do_not_match()
    {
        $this->makeRegistrationRequest([
            'password' => 'password',
            'password_confirmation' => 'password2',
        ])->assertStatus(422);
    }

    /** @test */
    public function it_errors_if_the_terms_arent_accepted()
    {
        $this->makeRegistrationRequest(['terms' => false])->assertStatus(422);
    }

    /** @test */
    public function it_creates_the_user()
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
    public function it_hashes_the_password()
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
    public function it_attaches_to_an_existing_inactive_shop_purchaser()
    {
        $this->withoutExceptionHandling();

        $existingUser = factory(User::class)->create(['user_level_id' => UserLevel::SHOP]);

        $this->assertCount(1, User::all());

        $this->makeRegistrationRequest(['email' => $existingUser->email]);

        $this->assertCount(1, User::all());

        $this->assertEquals(UserLevel::MEMBER, $existingUser->fresh()->user_level_id);
    }

    /** @test */
    public function it_dispatches_the_user_registered_event()
    {
        Event::fake();

        $this->makeRegistrationRequest();

        Event::assertDispatched(UserRegistered::class);
    }

    /** @test */
    public function it_sends_the_verify_email_notification()
    {
        $this->makeRegistrationRequest();

        Notification::assertSentTo(
            User::query()->first(),
            VerifyEmail::class,
        );
    }

    /** @test */
    public function it_logs_the_user_in_and_redirects_to_the_dashboard_after_a_successful_registration()
    {
        $this->assertFalse($this->isAuthenticated());

        $this->makeRegistrationRequest()->assertRedirect('/member/dashboard');

        $this->assertAuthenticatedAs(User::query()->first());
    }
}
