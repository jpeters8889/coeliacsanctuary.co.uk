<?php

declare(strict_types=1);

namespace Tests\Feature;

use Coeliac\Modules\Member\Notifications\ResendVerifyEmail;
use Illuminate\Support\Facades\Notification;
use Spatie\TestTime\TestTime;
use Tests\TestCase;
use Coeliac\Modules\Member\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VeryEmailTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create([
            'email_verified_at' => null,
        ]);

        $this->actingAs($this->user);
    }

    /** @test */
    public function it_can_generate_a_verify_email_link()
    {
        $this->assertNotNull($this->user->generateEmailVerificationLink());
    }

    /** @test */
    public function it_errors_if_we_visit_the_page_without_going_through_the_link()
    {
        $this->get('/member/verify-email/1/foo')->assertStatus(403);
    }

    /** @test */
    public function it_errors_if_we_modify_the_link()
    {
        $this->get($this->user->generateEmailVerificationLink() . 'foo')->assertStatus(403);
    }

    /** @test */
    public function it_errors_if_we_attempt_the_link_after_it_has_expired()
    {
        TestTime::freeze();

        $link = $this->user->generateEmailVerificationLink();

        TestTime::addMinutes(config('auth.verification.expire', 60))
            ->addMinute();

        $this->get($link)->assertStatus(403);
    }

    /** @test */
    public function it_errors_if_you_attempt_to_verify_a_different_user()
    {
        $this->actingAs(factory(User::class)->create());

        $this->get($this->user->generateEmailVerificationLink())->assertStatus(403);
    }

    /** @test */
    public function it_verifies_the_users_email()
    {
        $this->assertFalse($this->user->hasVerifiedEmail());

        $this->get($this->user->generateEmailVerificationLink());

        $this->assertTrue($this->user->fresh()->hasVerifiedEmail());
    }

    /** @test */
    public function it_can_resend_a_new_verification_link()
    {
        $this->withoutExceptionHandling();

        Notification::fake();

        $this->actingAs($user = factory(User::class)->create(['email_verified_at' => null]));

        $this->post('/member/verify-email');

        Notification::assertSentTo($user, ResendVerifyEmail::class);
    }
}
