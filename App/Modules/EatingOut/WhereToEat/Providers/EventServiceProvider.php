<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Providers;

use Coeliac\Modules\EatingOut\WhereToEat\Events\PlaceReportSubmitted;
use Coeliac\Modules\EatingOut\WhereToEat\Listeners\PlaceReportEmail;
use Coeliac\Modules\EatingOut\WhereToEat\Listeners\PlaceRequestEmail;
use Coeliac\Modules\EatingOut\WhereToEat\Events\PlaceRequestSubmitted;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        PlaceRequestSubmitted::class => [
            PlaceRequestEmail::class,
        ],

        PlaceReportSubmitted::class => [
            PlaceReportEmail::class,
        ]
    ];
}
