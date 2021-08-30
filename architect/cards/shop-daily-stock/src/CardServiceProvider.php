<?php

declare(strict_types=1);

namespace Coeliac\Architect\Cards\ShopDailyStock;

use JPeters\Architect\Architect;
use Illuminate\Support\ServiceProvider;

class CardServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Architect::isRunning(function () {
            /** @var Architect $architect */
            $architect = resolve(Architect::class);

            $architect->apiManager->registerEndpoint('get', 'shop-daily-stock', ApiHandler::class);
            $architect->assetManager->registerScript('ShopDailyStock', __DIR__.'/../dist/card.js');
            $architect->assetManager->registerStyle('ShopDailyStock', __DIR__.'/../dist/card.css');
        });
    }
}
