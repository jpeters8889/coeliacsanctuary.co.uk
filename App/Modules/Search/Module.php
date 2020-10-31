<?php

declare(strict_types=1);

namespace Coeliac\Modules\Search;

use Coeliac\Base\Modules;
use Coeliac\Modules\Search\Providers\RoutesServiceProvider;

class Module extends Modules
{
    public function getProviders(): array
    {
        return [
            RoutesServiceProvider::class,
        ];
    }
}
