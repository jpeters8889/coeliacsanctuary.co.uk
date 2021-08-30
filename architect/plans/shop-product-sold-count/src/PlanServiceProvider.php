<?php

declare(strict_types=1);

namespace Coeliac\Architect\Plans\ShopProductSoldCount;

use JPeters\Architect\Architect;
use Illuminate\Support\ServiceProvider;

class PlanServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Architect::isRunning(function () {
            /** @var Architect $architect */
            $architect = resolve(Architect::class);

            $architect->assetManager->registerScript('ShopProductSoldCount', __DIR__.'/../dist/plan.js');
            $architect->assetManager->registerStyle('ShopProductSoldCount', __DIR__.'/../dist/plan.css');
        });
    }
}
