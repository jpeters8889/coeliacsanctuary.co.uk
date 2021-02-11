<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Listeners;

use Illuminate\Notifications\AnonymousNotifiable;
use Coeliac\Modules\Member\Events\UserEmailChanged;
use Coeliac\Modules\Member\Notifications\EmailChangedAlert;

class SendEmailChangedAlert
{
    public function handle(UserEmailChanged $event)
    {
        (new AnonymousNotifiable())
            ->route('mail', $event->oldEmail())
            ->notify(new EmailChangedAlert($event->user()));
    }
}
