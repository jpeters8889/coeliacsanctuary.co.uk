<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Listeners;

use Coeliac\Modules\Member\Events\UserEmailChanged;
use Coeliac\Modules\Member\Notifications\VerifyEmail;

class SendEmailUpdatedVerificationEmail
{
    public function handle(UserEmailChanged $event)
    {
        $event->user()->notify(new VerifyEmail(false));
    }
}
