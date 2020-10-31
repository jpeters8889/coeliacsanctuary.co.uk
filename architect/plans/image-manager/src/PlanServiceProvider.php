<?php

declare(strict_types=1);

namespace Coeliac\Architect\Plans\ImageManager;

use JPeters\Architect\Architect;
use Illuminate\Support\ServiceProvider;

class PlanServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Architect::isRunning(function () {
            /** @var Architect $architect */
            $architect = resolve(Architect::class);

            $architect->apiManager->registerEndpoint('post', 'image-manager', ApiHandler::class, 'upload');
            $architect->assetManager->registerScript('ImageManager', __DIR__.'/../dist/plan.js');
            $architect->assetManager->registerStyle('ImageManager', __DIR__.'/../dist/plan.css');
        });
    }
}
