<?php

declare(strict_types=1);

namespace Coeliac\Architect\Plans\AddressLookup;

use JPeters\Architect\Architect;
use Illuminate\Support\ServiceProvider;

class PlanServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Architect::isRunning(function () {
            /** @var Architect $architect */
            $architect = resolve(Architect::class);

            $architect->apiManager->registerEndpoint('post', 'coeliac-address-lookup', ApiHandler::class, 'lookup');
            $architect->assetManager->registerScript('AddressLookup', __DIR__.'/../dist/plan.js');
            $architect->assetManager->registerScript('Google', 'https://maps.google.com/maps/api/js?key='.config('services.google.maps.admin'));
            $architect->assetManager->registerStyle('AddressLookup', __DIR__.'/../dist/plan.css');
        });
    }
}
