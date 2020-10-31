<?php

declare(strict_types=1);

namespace Coeliac\Architect\Cards\WteRatingsCard;

use JPeters\Architect\Architect;
use Illuminate\Support\ServiceProvider;

class CardServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Architect::isRunning(function () {
            /** @var Architect $architect */
            $architect = resolve(Architect::class);

            $architect->apiManager->registerEndpoint('delete', 'coeliac-wte-ratings', ApiHandler::class, 'delete');
            $architect->apiManager->registerEndpoint('put', 'coeliac-wte-ratings', ApiHandler::class, 'approve');

            $architect->assetManager->registerScript('WteRatingsCard', __DIR__.'/../dist/card.js');
            $architect->assetManager->registerStyle('WteRatingsCard', __DIR__.'/../dist/card.css');
        });
    }
}
