<?php

declare(strict_types=1);

namespace Coeliac\Modules\Competition;

use Coeliac\Base\Modules;
use Coeliac\Modules\Competition\Providers\RoutesServiceProvider;

class Module extends Modules
{
    public function getProviders(): array
    {
        return [
            RoutesServiceProvider::class,
        ];
    }
}
