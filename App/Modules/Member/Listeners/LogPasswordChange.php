<?php

namespace Coeliac\Modules\Member\Listeners;

use Coeliac\Modules\Member\Contracts\UserEvent;

class LogPasswordChange
{
    public function handle(UserEvent $event)
    {
        $event->user()->passwordChanges()->create([]);
    }
}
