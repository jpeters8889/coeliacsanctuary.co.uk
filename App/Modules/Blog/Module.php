<?php

declare(strict_types=1);

namespace Coeliac\Modules\Blog;

use Coeliac\Base\Modules;
use Coeliac\Modules\Blog\Providers\RoutesServiceProvider;

class Module extends Modules
{
    public function getProviders(): array
    {
        return [
            RoutesServiceProvider::class,
        ];
    }
}
