<?php

declare(strict_types=1);

namespace Coeliac\Common\Providers;

use Coeliac\Common\Events\ContactFormSubmitted;
use Coeliac\Common\Listeners\SendContactForm;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ContactFormSubmitted::class => [
            SendContactForm::class,
        ],
    ];
}
