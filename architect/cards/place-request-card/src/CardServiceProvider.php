<?php

declare(strict_types=1);

namespace Coeliac\Architect\Cards\PlaceRequestCard;

use JPeters\Architect\Architect;
use Illuminate\Support\ServiceProvider;

class CardServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Architect::isRunning(function () {
            /** @var Architect $architect */
            $architect = resolve(Architect::class);

            $architect->apiManager->registerEndpoint('delete', 'coeliac-place-request', ApiHandler::class, 'delete');
            $architect->apiManager->registerEndpoint('put', 'coeliac-place-request', ApiHandler::class, 'complete');

            $architect->assetManager->registerScript('PlaceRequestCard', __DIR__.'/../dist/card.js');
            $architect->assetManager->registerStyle('PlaceRequestCard', __DIR__.'/../dist/card.css');
        });
    }
}
