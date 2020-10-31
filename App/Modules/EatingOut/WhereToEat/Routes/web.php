<?php

declare(strict_types=1);

use Illuminate\Routing\Router;
use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatController;
use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatAppController;
use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatTownController;
use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatCountyController;
use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatSearchController;
use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatPlaceRequestController;

/* @var Router $router */

if (!isset($router)) {
    return;
}

$router->group(['prefix' => '/wheretoeat'], function () use ($router) {
    $router->get('/', [WhereToEatController::class, 'index']);
    $router->get('/map', [WhereToEatController::class, 'index']);
    $router->get('/list', [WhereToEatController::class, 'index']);
    $router->get('/nationwide', [WhereToEatController::class, 'index']);

    $router->get('/place-request', [WhereToEatPlaceRequestController::class, 'get']);
    $router->get('/coeliac-sanctuary-on-the-go', [WhereToEatAppController::class, 'get']);

    $router->get('/search/{term}', [WhereToEatSearchController::class, 'get']);

    $router->get('/{county}', [WhereToEatCountyController::class, 'list']);

    $router->get('/{county}/{town}', [WhereToEatTownController::class, 'list']);
});
