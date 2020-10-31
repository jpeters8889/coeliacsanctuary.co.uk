<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;
use Tests\Mocks\TestNewsletterService;
use Coeliac\Common\Newsletter\NewsletterService;
use Coeliac\Common\Newsletter\Exceptions\AlreadySubscribedException;

class NewsletterTest extends TestCase
{
    private TestNewsletterService $newsletterSignup;

    public function setUp(): void
    {
        parent::setUp();

        $this->newsletterSignup = new TestNewsletterService();

        $this->instance(NewsletterService::class, $this->newsletterSignup);
    }

    /** @test */
    public function it_signs_up_a_user()
    {
        $email = 'me@you.com';

        $this->newsletterSignup->subscribe($email);

        $this->assertContains($email, $this->newsletterSignup->subscribers);

        $this->assertEquals(1, count($this->newsletterSignup->subscribers));
    }

    /** @test */
    public function it_rejects_duplicate_emails()
    {
        $email = 'me@you.com';

        $this->newsletterSignup->subscribe($email);

        $this->assertContains($email, $this->newsletterSignup->subscribers);

        $this->expectException(AlreadySubscribedException::class);

        $this->newsletterSignup->subscribe($email);

        $this->assertEquals(1, count($this->newsletterSignup->subscribers));
    }
}
