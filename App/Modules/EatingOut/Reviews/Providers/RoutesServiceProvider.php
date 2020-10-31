<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\Reviews\Providers;

use Coeliac\Base\Providers\BaseRouteProvider;

class RoutesServiceProvider extends BaseRouteProvider
{
    protected $namespace = 'Coeliac\Modules\EatingOut\Reviews\Controllers';

    protected $path = 'App/Modules/EatingOut/Reviews/Routes/';

    protected $maps = ['api', 'web'];
}
