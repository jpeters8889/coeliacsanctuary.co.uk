<?php

declare(strict_types=1);

namespace Coeliac\Modules\Blog\Providers;

use Coeliac\Base\Providers\BaseRouteProvider;

class RoutesServiceProvider extends BaseRouteProvider
{
    protected $namespace = 'Coeliac\Modules\Blog\Controllers';

    protected $path = 'App/Modules/Blog/Routes/';

    protected $maps = ['api', 'web'];
}
