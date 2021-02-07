<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Providers;

use Coeliac\Modules\Member\Events\UserRegistered;
use Coeliac\Modules\Member\Listeners\SendEmailVerificationEmail;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UserRegistered::class => [
            SendEmailVerificationEmail::class,
        ],
    ];
}
