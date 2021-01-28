<?php

declare(strict_types=1);

namespace Coeliac\Modules\Search\Providers;

use Coeliac\Base\Providers\BaseRouteProvider;

class RoutesServiceProvider extends BaseRouteProvider
{
    protected $path = 'App/Modules/Search/Routes/';

    protected $maps = ['web', 'api'];
}
