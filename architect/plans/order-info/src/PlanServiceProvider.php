<?php

declare(strict_types=1);

namespace Coeliac\Architect\Plans\OrderInfo;

use JPeters\Architect\Architect;
use Illuminate\Support\ServiceProvider;

class PlanServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Architect::isRunning(function () {
            /** @var Architect $architect */
            $architect = resolve(Architect::class);

            $architect->apiManager->registerEndpoint('get', 'order-info', ApiHandler::class, 'get');
            $architect->assetManager->registerScript('OrderInfo', __DIR__.'/../dist/plan.js');
            $architect->assetManager->registerStyle('OrderInfo', __DIR__.'/../dist/plan.css');
        });
    }
}
