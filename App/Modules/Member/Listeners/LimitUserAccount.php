<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Listeners;

use Coeliac\Modules\Member\Events\UserEmailChanged;

class LimitUserAccount
{
    public function handle(UserEmailChanged $event): void
    {
        $event->user()->update(['email_verified_at' => null]);
    }
}
