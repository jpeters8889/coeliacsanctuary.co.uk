<?php

declare(strict_types=1);

namespace Tests\Feature\Common\Newsletter;

use Illuminate\Container\Container;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Spatie\Mailcoach\Domain\Audience\Models\EmailList;
use Tests\TestCase;

class MailcoachNewsletterTest extends TestCase
{
    use WithFaker;

    private EmailList $list;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpFaker();

        Mail::fake();
        Notification::fake();
        Queue::fake();

        $this->list = EmailList::create([
            'name' => 'Test List',
            'uuid' => $this->faker->uuid,
            'default_from_email' => $this->faker->email,
            'default_from_name' => $this->faker->name,
            'default_reply_to_email' => $this->faker->email,
            'default_reply_to_name' => $this->faker->name,
            'campaign_mailer' => config('mail.default') ?? 'array',
            'transactional_mailer' => config('mail.default') ?? 'array',
        ]);

        Container::getInstance()->make(ConfigRepository::class)->set(['coeliac.newsletter.list' => 'Test List']);
    }

    /** @test */
    public function itErrorsWithoutAnEmail()
    {
        $this->assertEmpty($this->list->subscribers);

        $this->post('/api/newsletter', ['email' => null])->assertStatus(422);

        $this->assertEmpty($this->list->fresh()->subscribers);
    }

    /** @test */
    public function itRejectsInvalidEmails()
    {
        $this->assertEmpty($this->list->subscribers);

        $this->post('/api/newsletter', ['email' => 'foo'])->assertStatus(422);

        $this->assertEmpty($this->list->fresh()->subscribers);
    }

    /** @test */
    public function itErrorsWithoutAnUrl()
    {
        $this->assertEmpty($this->list->subscribers);

        $this->post('/api/newsletter', ['url' => null])->assertStatus(422);

        $this->assertEmpty($this->list->fresh()->subscribers);
    }

    /** @test */
    public function itReturnsSuccessfulWhenSigningUpAUser()
    {
        $this->assertEmpty($this->list->subscribers);

        $this->post('/api/newsletter', ['email' => 'me@you.com', 'url' => ''])
            ->assertStatus(200);

        $this->assertNotEmpty($this->list->fresh()->subscribers);
        $this->assertEquals('me@you.com', $this->list->subscribers()->first()->email);
    }

    /** @test */
    public function itErrorsWhenTryingToSignupWhenAlreadySubscribed()
    {
        $this->post('/api/newsletter', ['email' => 'me@you.com', 'url' => '']);

        $this->assertCount(1, $this->list->fresh()->subscribers);

        $this->post('/api/newsletter', ['email' => 'me@you.com', 'url' => ''])
            ->assertStatus(409);

        $this->assertCount(1, $this->list->fresh()->subscribers);
    }
}
