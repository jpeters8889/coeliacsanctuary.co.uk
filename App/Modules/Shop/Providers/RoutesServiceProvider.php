<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Providers;

use Coeliac\Base\Providers\BaseRouteProvider;

class RoutesServiceProvider extends BaseRouteProvider
{
    protected $namespace = 'Coeliac\Modules\Shop\Controllers';

    protected $path = 'App/Modules/Shop/Routes/';

    protected $maps = ['api', 'web'];
}
