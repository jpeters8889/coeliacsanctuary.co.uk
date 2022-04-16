<?php

namespace Coeliac\Architect\Cards\WteSuggestedEdits;

use JPeters\Architect\Architect;
use Illuminate\Support\ServiceProvider;

class CardServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Architect::isRunning(function () {
            /** @var Architect $architect */
            $architect = Architect::getInstance();

            $architect->apiManager->registerEndpoint('get', 'coeliac-wte-suggested-edits', ApiHandler::class, 'get');
            $architect->apiManager->registerEndpoint('put', 'coeliac-wte-suggested-edits', ApiHandler::class, 'accept');
            $architect->apiManager->registerEndpoint('delete', 'coeliac-wte-suggested-edits', ApiHandler::class, 'reject');


            $architect->assetManager->registerScript('WteSuggestedEdits', __DIR__ . '/../dist/card.js');
            $architect->assetManager->registerStyle('WteSuggestedEdits', __DIR__ . '/../dist/card.css');
        });
    }
}
