<?php

declare(strict_types=1);

namespace Tests\Mocks;

use Coeliac\Common\Newsletter\NewsletterService;
use Coeliac\Common\Newsletter\Exceptions\AlreadySubscribedException;

class TestNewsletterService implements NewsletterService
{
    public $subscribers = [];

    public function subscribe($email, $url = '')
    {
        if (in_array($email, $this->subscribers)) {
            throw new AlreadySubscribedException('Already Subscribed');
        }

        $this->subscribers[] = $email;

        return true;
    }
}
