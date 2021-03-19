<?php

declare(strict_types=1);

namespace Coeliac\Architect\Plans\CompetitionEntries;

use JPeters\Architect\Architect;
use Illuminate\Support\ServiceProvider;

class PlanServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Architect::isRunning(function () {
            /** @var Architect $architect */
            $architect = Architect::getInstance();

            $architect->apiManager->registerEndpoint('get', 'competition-entries', ApiHandler::class, 'get');
            $architect->assetManager->registerScript('CompetitionEntries', __DIR__.'/../dist/plan.js');
            $architect->assetManager->registerStyle('CompetitionEntries', __DIR__.'/../dist/plan.css');
        });
    }
}
