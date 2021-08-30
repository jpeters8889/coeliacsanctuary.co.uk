<?php

declare(strict_types=1);

namespace Tests\Mocks;

use Coeliac\Common\Newsletter\NewsletterService;
use Coeliac\Common\Newsletter\Exceptions\AlreadySubscribedException;

class TestNewsletterService implements NewsletterService
{
    public array $subscribers = [];

    public function subscribe(string $email, ?string $url = ''): void
    {
        if (in_array($email, $this->subscribers)) {
            throw new AlreadySubscribedException('Already Subscribed');
        }

        $this->subscribers[] = $email;
    }
}
