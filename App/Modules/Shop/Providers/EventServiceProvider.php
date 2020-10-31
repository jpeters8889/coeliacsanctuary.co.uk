<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Providers;

use Coeliac\Modules\Shop\Events\ShipOrder;
use Coeliac\Modules\Shop\Events\CancelOrder;
use Coeliac\Modules\Shop\Events\CreateOrder;
use Coeliac\Modules\Shop\Events\BasketClosed;
use Coeliac\Modules\Shop\Events\CompleteOrder;
use Coeliac\Modules\Shop\Listeners\ResetStock;
use Coeliac\Modules\Shop\Listeners\OrderCreated;
use Coeliac\Modules\Shop\Listeners\OrderShipped;
use Coeliac\Modules\Shop\Listeners\OrderCancelled;
use Coeliac\Modules\Shop\Listeners\OrderCompleted;
use Coeliac\Common\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        CreateOrder::class => [OrderCreated::class],
        CancelOrder::class => [OrderCancelled::class],
        ShipOrder::class => [OrderShipped::class],
        CompleteOrder::class => [OrderCompleted::class],
        BasketClosed::class => [ResetStock::class],
    ];
}
