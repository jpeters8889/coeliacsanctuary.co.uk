<?php

namespace Coeliac\Architect\Plans\WteNationwideBranches;

use JPeters\Architect\Architect;
use Illuminate\Support\ServiceProvider;

class PlanServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Architect::isRunning(function () {
            /** @var Architect $architect */
            $architect = Architect::getInstance();

            $architect->apiManager->registerEndpoint('post', 'coeliac-wte-nationwide-branches', ApiHandler::class);
            $architect->assetManager->registerScript('WteNationwideBranches', __DIR__.'/../dist/plan.js');
            $architect->assetManager->registerStyle('WteNationwideBranches', __DIR__.'/../dist/plan.css');
        });
    }
}
