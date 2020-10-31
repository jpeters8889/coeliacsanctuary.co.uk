<?php

declare(strict_types=1);

namespace Coeliac\Modules\Info\Providers;

use Coeliac\Base\Providers\BaseRouteProvider;

class RoutesServiceProvider extends BaseRouteProvider
{
    protected $namespace = 'Coeliac\Modules\Info\Controllers';

    protected $path = 'App/Modules/Info/Routes/';
}
