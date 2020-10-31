<?php

declare(strict_types=1);

namespace Coeliac\Architect\Plans\OrderShipped;

use JPeters\Architect\Architect;
use Illuminate\Support\ServiceProvider;

class PlanServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Architect::isRunning(function () {
            /** @var Architect $architect */
            $architect = resolve(Architect::class);

            $architect->apiManager->registerEndpoint('post', 'order', ApiHandler::class, 'cancel');
            $architect->apiManager->registerEndpoint('post', 'order', ApiHandler::class, 'ship');

            $architect->assetManager->registerScript('OrderShipped', __DIR__.'/../dist/plan.js');
            $architect->assetManager->registerStyle('OrderShipped', __DIR__.'/../dist/plan.css');
        });
    }
}
