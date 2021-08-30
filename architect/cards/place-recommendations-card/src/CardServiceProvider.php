<?php

declare(strict_types=1);

namespace Coeliac\Architect\Cards\PlaceRecommendationsCard;

use JPeters\Architect\Architect;
use Illuminate\Support\ServiceProvider;

class CardServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Architect::isRunning(function () {
            /** @var Architect $architect */
            $architect = resolve(Architect::class);

            $architect->apiManager->registerEndpoint('delete', 'coeliac-place-recommendations', ApiHandler::class, 'delete');
            $architect->apiManager->registerEndpoint('put', 'coeliac-place-recommendations', ApiHandler::class, 'complete');

            $architect->assetManager->registerScript('PlaceRecommendationsCard', __DIR__.'/../dist/card.js');
            $architect->assetManager->registerStyle('PlaceRecommendationsCard', __DIR__.'/../dist/card.css');
        });
    }
}
