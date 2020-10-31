<?php

declare(strict_types=1);

namespace Coeliac\Modules\Recipe;

use Coeliac\Base\Modules;
use Coeliac\Modules\Recipe\Providers\RoutesServiceProvider;

class Module extends Modules
{
    public function getProviders(): array
    {
        return [
            RoutesServiceProvider::class,
        ];
    }
}
