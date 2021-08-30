<?php

declare(strict_types=1);

namespace Coeliac\Common\Newsletter;

interface NewsletterService
{
    public function subscribe(string $email, ?string $url): void;
}
