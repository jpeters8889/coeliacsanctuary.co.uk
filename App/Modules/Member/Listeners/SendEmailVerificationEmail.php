<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Listeners;

use Coeliac\Modules\Member\Events\UserRegistered;
use Coeliac\Modules\Member\Notifications\VerifyEmail;

class SendEmailVerificationEmail
{
    public function handle(UserRegistered $event)
    {
        $event->user()->notify(new VerifyEmail());
    }
}
