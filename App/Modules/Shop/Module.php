<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop;

use Coeliac\Base\Modules;
use Coeliac\Modules\Shop\Providers\BasketServiceProvider;
use Coeliac\Modules\Shop\Providers\EventServiceProvider;
use Coeliac\Modules\Shop\Providers\PaymentServiceProvider;
use Coeliac\Modules\Shop\Providers\PostcodeLookupServiceProvider;
use Coeliac\Modules\Shop\Providers\RoutesServiceProvider;

class Module extends Modules
{
    public function getProviders(): array
    {
        return [
            RoutesServiceProvider::class,
            PostcodeLookupServiceProvider::class,
            BasketServiceProvider::class,
            PaymentServiceProvider::class,
            EventServiceProvider::class,
        ];
    }
}
