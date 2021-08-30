<?php

declare(strict_types=1);

namespace Coeliac\Architect\Plans\ShopProductPrices;

use JPeters\Architect\Architect;
use Illuminate\Support\ServiceProvider;

class PlanServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Architect::isRunning(function () {
            /** @var Architect $architect */
            $architect = resolve(Architect::class);

            $architect->apiManager->registerEndpoint('get', 'coeliac-shop-product-prices', ApiHandler::class, 'prices');
            $architect->assetManager->registerScript('ShopProductPrices', __DIR__.'/../dist/plan.js');
            $architect->assetManager->registerStyle('ShopProductPrices', __DIR__.'/../dist/plan.css');
        });
    }
}
