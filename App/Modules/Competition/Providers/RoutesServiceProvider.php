<?php

declare(strict_types=1);

namespace Coeliac\Modules\Competition\Providers;

use Coeliac\Base\Providers\BaseRouteProvider;

class RoutesServiceProvider extends BaseRouteProvider
{
    protected $maps = ['web', 'api'];

    protected $path = 'App/Modules/Competition/Routes/';
}
