<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Listeners;

use Coeliac\Modules\Member\Events\UserEmailChanged;
use Coeliac\Modules\Member\Notifications\EmailChangedAlert;
use Illuminate\Notifications\AnonymousNotifiable;

class SendEmailChangedAlert
{
    public function handle(UserEmailChanged $event): void
    {
        (new AnonymousNotifiable())
            ->route('mail', $event->oldEmail())
            ->notify(new EmailChangedAlert($event->user()));
    }
}
