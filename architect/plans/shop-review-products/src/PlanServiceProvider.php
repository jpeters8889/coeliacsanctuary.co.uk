<?php

namespace Coeliac\Architect\Plans\ShopReviewProducts;

use JPeters\Architect\Architect;
use Illuminate\Support\ServiceProvider;

class PlanServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Architect::isRunning(function () {
            /** @var Architect $architect */
            $architect = Architect::getInstance();

            $architect->apiManager->registerEndpoint('get', 'shop-review-products', ApiHandler::class, 'getProducts');
            $architect->apiManager->registerEndpoint('get', 'shop-review-products', ApiHandler::class, 'productList');

            $architect->assetManager->registerScript('ShopReviewProducts', __DIR__.'/../dist/plan.js');
            $architect->assetManager->registerStyle('ShopReviewProducts', __DIR__.'/../dist/plan.css');
        });
    }
}
