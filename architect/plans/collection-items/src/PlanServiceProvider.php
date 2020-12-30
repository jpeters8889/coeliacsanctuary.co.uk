<?php

declare(strict_types=1);

namespace Coeliac\Architect\Plans\CollectionItems;

use JPeters\Architect\Architect;
use Illuminate\Support\ServiceProvider;

class PlanServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Architect::isRunning(function () {
            /** @var Architect $architect */
            $architect = Architect::getInstance();

            $architect->apiManager->registerEndpoint('post', 'collection-items', ApiHandler::class, 'search');

            $architect->assetManager->registerScript('CollectionItems', __DIR__.'/../dist/plan.js');
            $architect->assetManager->registerStyle('CollectionItems', __DIR__.'/../dist/plan.css');
        });
    }
}
