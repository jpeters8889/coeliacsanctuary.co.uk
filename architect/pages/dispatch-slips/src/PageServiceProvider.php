<?php

declare(strict_types=1);

namespace Coeliac\Architect\Pages\DispatchSlips;

use JPeters\Architect\Architect;
use Illuminate\Support\ServiceProvider;

class PageServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Architect::isRunning(function () {
            /** @var Architect $architect */
            $architect = resolve(Architect::class);

            $architect->apiManager->registerEndpoint('get', 'coeliac-dispatch-slips', ApiHandler::class, 'render');
            $architect->apiManager->registerEndpoint('put', 'coeliac-dispatch-slips', ApiHandler::class, 'printed');

            $architect->assetManager->registerScript('DispatchSlips', __DIR__.'/../dist/page.js');
            $architect->assetManager->registerStyle('DispatchSlips', __DIR__.'/../dist/page.css');
        });
    }
}
