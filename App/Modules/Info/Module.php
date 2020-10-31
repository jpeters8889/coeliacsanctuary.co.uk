<?php

declare(strict_types=1);

namespace Coeliac\Modules\Info;

use Coeliac\Base\Modules;
use Coeliac\Modules\Info\Providers\RoutesServiceProvider;

class Module extends Modules
{
    public function getProviders(): array
    {
        return [
            RoutesServiceProvider::class,
        ];
    }
}
