<?php

declare(strict_types=1);

namespace Coeliac\Architect\Plans\CoeliacShopOrderItems;

use JPeters\Architect\Architect;
use Illuminate\Support\ServiceProvider;

class PlanServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Architect::isRunning(function () {
            /** @var Architect $architect */
            $architect = resolve(Architect::class);

            $architect->apiManager->registerEndpoint('get', 'coeliac-shop-order-items', ApiHandler::class, 'items');
            $architect->assetManager->registerScript('CoeliacShopOrderItems', __DIR__.'/../dist/plan.js');
            $architect->assetManager->registerStyle('CoeliacShopOrderItems', __DIR__.'/../dist/plan.css');
        });
    }
}
