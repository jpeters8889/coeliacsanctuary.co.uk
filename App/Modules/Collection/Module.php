<?php

declare(strict_types=1);

namespace Coeliac\Modules\Collection;

use Coeliac\Base\Modules;
use Coeliac\Modules\Collection\Providers\RoutesServiceProvider;

class Module extends Modules
{
    public function getProviders(): array
    {
        return [
            RoutesServiceProvider::class,
        ];
    }
}
