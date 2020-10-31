<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut;

use Coeliac\Base\Modules;
use Coeliac\Modules\EatingOut\Providers\RoutesServiceProvider;
use Coeliac\Modules\EatingOut\WhereToEat\Providers\EventServiceProvider;
use Coeliac\Modules\EatingOut\WhereToEat\Providers\GeocoderServiceProvider;
use Coeliac\Modules\EatingOut\Reviews\Providers\RoutesServiceProvider as ReviewRoutesServiceProvider;
use Coeliac\Modules\EatingOut\WhereToEat\Providers\RoutesServiceProvider as WhereToEatRoutesServiceProvider;

class Module extends Modules
{
    public function getProviders(): array
    {
        return [
            EventServiceProvider::class,
            RoutesServiceProvider::class,
            WhereToEatRoutesServiceProvider::class,
            ReviewRoutesServiceProvider::class,
            GeocoderServiceProvider::class,
        ];
    }
}
