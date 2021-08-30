<?php

declare(strict_types=1);

namespace Coeliac\Architect\Plans\TagManager;

use JPeters\Architect\Architect;
use Illuminate\Support\ServiceProvider;

class PlanServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Architect::isRunning(function () {
            /** @var Architect $architect */
            $architect = resolve(Architect::class);

            $architect->apiManager->registerEndpoint('post', 'tag-manager', ApiHandler::class, 'search');
            $architect->assetManager->registerScript('TagManager', __DIR__.'/../dist/plan.js');
            $architect->assetManager->registerStyle('TagManager', __DIR__.'/../dist/plan.css');
        });
    }
}
