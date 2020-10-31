<?php

declare(strict_types=1);

namespace Coeliac\Common\Providers;

use Coeliac\Base\Providers\BaseRouteProvider;

class RouteServiceProvider extends BaseRouteProvider
{
    protected $maps = ['web', 'api'];
}
