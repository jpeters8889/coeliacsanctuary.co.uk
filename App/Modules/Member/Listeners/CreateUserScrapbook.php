<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Listeners;

use Coeliac\Modules\Member\Events\UserRegistered;

class CreateUserScrapbook
{
    public function handle(UserRegistered $event)
    {
        $event->user()->scrapbooks()->create();
    }
}
