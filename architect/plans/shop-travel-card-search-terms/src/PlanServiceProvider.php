<?php

namespace Coeliac\Architect\Plans\ShopTravelCardSearchTerms;

use JPeters\Architect\Architect;
use Illuminate\Support\ServiceProvider;

class PlanServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Architect::isRunning(function () {
            /** @var Architect $architect */
            $architect = Architect::getInstance();

            $architect->apiManager->registerEndpoint('get', 'travel-card-products', ApiHandler::class);
            $architect->assetManager->registerScript('ShopTravelCardSearchTerms', __DIR__.'/../dist/plan.js');
            $architect->assetManager->registerStyle('ShopTravelCardSearchTerms', __DIR__.'/../dist/plan.css');
        });
    }
}
