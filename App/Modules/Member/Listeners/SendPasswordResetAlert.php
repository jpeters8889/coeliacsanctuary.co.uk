<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Listeners;

use Coeliac\Modules\Member\Events\UserPasswordReset;
use Coeliac\Modules\Member\Notifications\PasswordResetAlert;

class SendPasswordResetAlert
{
    public function handle(UserPasswordReset $event)
    {
        $event->user()->notify(new PasswordResetAlert());
    }
}
