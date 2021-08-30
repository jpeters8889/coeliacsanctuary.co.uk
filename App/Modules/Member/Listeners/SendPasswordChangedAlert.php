<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Listeners;

use Coeliac\Modules\Member\Events\UserPasswordUpdated;
use Coeliac\Modules\Member\Notifications\PasswordChangedAlert;

class SendPasswordChangedAlert
{
    public function handle(UserPasswordUpdated $event): void
    {
        $event->user()->notify(new PasswordChangedAlert());
    }
}
