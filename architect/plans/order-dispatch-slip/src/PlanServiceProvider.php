<?php

declare(strict_types=1);

namespace Coeliac\Architect\Plans\OrderDispatchSlip;

use JPeters\Architect\Architect;
use Illuminate\Support\ServiceProvider;

class PlanServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Architect::isRunning(function () {
            /** @var Architect $architect */
            $architect = resolve(Architect::class);

//            $architect->apiManager->registerEndpoint('post', 'Coeliac-OrderDispatchSlip', ApiHandler::class);
            $architect->assetManager->registerScript('OrderDispatchSlip', __DIR__.'/../dist/plan.js');
            $architect->assetManager->registerStyle('OrderDispatchSlip', __DIR__.'/../dist/plan.css');
        });
    }
}
