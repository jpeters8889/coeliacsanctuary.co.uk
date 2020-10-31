<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Providers;

use Coeliac\Base\Providers\BaseRouteProvider;

class RoutesServiceProvider extends BaseRouteProvider
{
    protected $namespace = 'Coeliac\Modules\EatingOut\WhereToEat\Controllers';

    protected $path = 'App/Modules/EatingOut/WhereToEat/Routes/';

    protected $maps = ['web', 'api'];
}
