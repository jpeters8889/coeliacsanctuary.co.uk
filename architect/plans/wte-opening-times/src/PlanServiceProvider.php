<?php

namespace Coeliac\Architect\Plans\WteOpeningTimes;

use JPeters\Architect\Architect;
use Illuminate\Support\ServiceProvider;

class PlanServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Architect::isRunning(function () {
            /** @var Architect $architect */
            $architect = Architect::getInstance();

            $architect->apiManager->registerEndpoint('post', 'coeliac-wte-opening-times', ApiHandler::class);
            $architect->assetManager->registerScript('WteOpeningTimes', __DIR__.'/../dist/plan.js');
            $architect->assetManager->registerStyle('WteOpeningTimes', __DIR__.'/../dist/plan.css');
        });
    }
}
