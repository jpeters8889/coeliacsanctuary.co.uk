<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member;

use Coeliac\Base\Modules;
use Coeliac\Modules\Member\Providers\EventServiceProvider;
use Coeliac\Modules\Member\Providers\RoutesServiceProvider;

class Module extends Modules
{
    public function getProviders(): array
    {
        return [
            RoutesServiceProvider::class,
            EventServiceProvider::class,
        ];
    }
}
