<?php

declare(strict_types=1);

namespace Coeliac\Modules\Collection\Providers;

use Coeliac\Base\Providers\BaseRouteProvider;

class RoutesServiceProvider extends BaseRouteProvider
{
    protected $namespace = 'Coeliac\Modules\Collection\Controllers';

    protected $path = 'App/Modules/Collection/Routes/';

    protected $maps = ['api', 'web'];
}
