<?php

declare(strict_types=1);

use Coeliac\Modules\Collection\Controllers\CollectionController;
use Illuminate\Routing\Router;

/* @var Router $router */

if (! isset($router)) {
    return;
}

$router->group(['prefix' => 'collection'], static function () use ($router) {
    $router->get('/', [CollectionController::class, 'index']);

    $router->get('/{slug}', [CollectionController::class, 'show']);
});
