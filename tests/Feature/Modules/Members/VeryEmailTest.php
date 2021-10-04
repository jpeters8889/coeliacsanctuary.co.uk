<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Members;

use Tests\TestCase;
use Spatie\TestTime\TestTime;
use Coeliac\Modules\Member\Models\User;
use Illuminate\Support\Facades\Notification;
use Coeliac\Modules\Member\Notifications\ResendVerifyEmail;

class VeryEmailTest extends TestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->build(User::class)
            ->notVerified()
            ->create();

        $this->actingAs($this->user);
    }

    /** @test */
    public function itCanGenerateAVerifyEmailLink()
    {
        $this->assertNotNull($this->user->generateEmailVerificationLink());
    }

    /** @test */
    public function itErrorsIfWeVisitThePageWithoutGoingThroughTheLink()
    {
        $this->get('/member/verify-email/1/foo')->assertStatus(403);
    }

    /** @test */
    public function itErrorsIfWeModifyTheLink()
    {
        $this->get($this->user->generateEmailVerificationLink().'foo')->assertStatus(403);
    }

    /** @test */
    public function itErrorsIfWeAttemptTheLinkAfterItHasExpired()
    {
        TestTime::freeze();

        $link = $this->user->generateEmailVerificationLink();

        TestTime::addMinutes(config('auth.verification.expire', 60))
            ->addMinute();

        $this->get($link)->assertStatus(403);
    }

    /** @test */
    public function itErrorsIfYouAttemptToVerifyADifferentUser()
    {
        $this->actingAs($this->create(User::class));

        $this->get($this->user->generateEmailVerificationLink())->assertStatus(403);
    }

    /** @test */
    public function itVerifiesTheUsersEmail()
    {
        $this->assertFalse($this->user->hasVerifiedEmail());

        $this->get($this->user->generateEmailVerificationLink());

        $this->assertTrue($this->user->fresh()->hasVerifiedEmail());
    }

    /** @test */
    public function itCanResendANewVerificationLink()
    {
        $this->withoutExceptionHandling();

        Notification::fake();

        $this->actingAs($user = $this->build(User::class)->notVerified()->create());

        $this->post('/api/member/verify-email');

        Notification::assertSentTo($user, ResendVerifyEmail::class);
    }
}
