<?php

declare(strict_types=1);

namespace Coeliac\Architect\Plans\ShopProductVariants;

use JPeters\Architect\Architect;
use Illuminate\Support\ServiceProvider;

class PlanServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Architect::isRunning(function () {
            /** @var Architect $architect */
            $architect = resolve(Architect::class);

            $architect->apiManager->registerEndpoint('get', 'coeliac-shop-product-variants', ApiHandler::class, 'variants');

            $architect->assetManager->registerScript('ShopProductVariants', __DIR__.'/../dist/plan.js');
            $architect->assetManager->registerStyle('ShopProductVariants', __DIR__.'/../dist/plan.css');
        });
    }
}
