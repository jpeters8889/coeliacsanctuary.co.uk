<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\Providers;

use Coeliac\Base\Providers\BaseRouteProvider;

class RoutesServiceProvider extends BaseRouteProvider
{
    protected $namespace = 'Coeliac\Modules\EatingOut\Controllers';

    protected $path = 'App/Modules/EatingOut/Routes/';
}
