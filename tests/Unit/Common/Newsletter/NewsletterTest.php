<?php

declare(strict_types=1);

namespace Tests\Unit\Common\Newsletter;

use Coeliac\Common\Newsletter\Exceptions\AlreadySubscribedException;
use Coeliac\Common\Newsletter\NewsletterService;
use Tests\Mocks\TestNewsletterService;
use Tests\TestCase;

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
    public function itSignsUpAUser()
    {
        $email = 'me@you.com';

        $this->newsletterSignup->subscribe($email);

        $this->assertContains($email, $this->newsletterSignup->subscribers);

        $this->assertEquals(1, count($this->newsletterSignup->subscribers));
    }

    /** @test */
    public function itRejectsDuplicateEmails()
    {
        $email = 'me@you.com';

        $this->newsletterSignup->subscribe($email);

        $this->assertContains($email, $this->newsletterSignup->subscribers);

        $this->expectException(AlreadySubscribedException::class);

        $this->newsletterSignup->subscribe($email);

        $this->assertEquals(1, count($this->newsletterSignup->subscribers));
    }
}
