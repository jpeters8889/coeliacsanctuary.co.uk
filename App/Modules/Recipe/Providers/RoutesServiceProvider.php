<?php

declare(strict_types=1);

namespace Coeliac\Modules\Recipe\Providers;

use Coeliac\Base\Providers\BaseRouteProvider;

class RoutesServiceProvider extends BaseRouteProvider
{
    protected $namespace = 'Coeliac\Modules\Recipe\Controllers';

    protected $path = 'App/Modules/Recipe/Routes/';

    protected $maps = ['web', 'api'];
}
