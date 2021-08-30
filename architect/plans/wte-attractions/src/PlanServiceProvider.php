<?php

declare(strict_types=1);

namespace Coeliac\Architect\Plans\WteAttractions;

use JPeters\Architect\Architect;
use Illuminate\Support\ServiceProvider;

class PlanServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Architect::isRunning(function () {
            /** @var Architect $architect */
            $architect = Architect::getInstance();

            $architect->apiManager->registerEndpoint('post', 'coeliac-wte-attractions', ApiHandler::class);
            $architect->assetManager->registerScript('WteAttractions', __DIR__.'/../dist/plan.js');
            $architect->assetManager->registerStyle('WteAttractions', __DIR__.'/../dist/plan.css');
        });
    }
}
