<?php

declare(strict_types=1);

namespace Coeliac\Architect\Cards\PlaceReportsCard;

use JPeters\Architect\Architect;
use Illuminate\Support\ServiceProvider;

class CardServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Architect::isRunning(function () {
            /** @var Architect $architect */
            $architect = resolve(Architect::class);

            $architect->apiManager->registerEndpoint('delete', 'coeliac-place-reports', ApiHandler::class, 'delete');
            $architect->apiManager->registerEndpoint('put', 'coeliac-place-reports', ApiHandler::class, 'complete');

            $architect->assetManager->registerScript('PlaceReportsCard', __DIR__.'/../dist/card.js');
            $architect->assetManager->registerStyle('PlaceReportsCard', __DIR__.'/../dist/card.css');
        });
    }
}
