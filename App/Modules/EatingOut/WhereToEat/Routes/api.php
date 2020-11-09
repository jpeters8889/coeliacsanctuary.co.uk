<?php

declare(strict_types=1);

use Illuminate\Routing\Router;
use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatController;
use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatSearchController;
use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatRatingsController;
use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatSummaryController;
use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatSettingsController;
use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatVenueTypesController;
use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatQuickSearchController;
use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatPlaceRequestController;

/* @var Router $router */

if (!isset($router)) {
    return;
}

$router->group(['prefix' => '/api/wheretoeat'], function () use ($router) {
    $router->get('/', [WhereToEatController::class, 'list']);
    $router->get('/summary', [WhereToEatSummaryController::class, 'get']);
    $router->get('/venueTypes', [WhereToEatVenueTypesController::class, 'get']);
    $router->get('/settings', [WhereToEatSettingsController::class, 'get']);

    $router->post('/place-request', [WhereToEatPlaceRequestController::class, 'create']);

    $router->post('/quick-search', [WhereToEatQuickSearchController::class, 'get']);

    $router->post('/search', [WhereToEatSearchController::class, 'create']);

    $router->group(['middleware' => 'userHasNotRatedEatery'], function () use ($router) {
        $router->post('/{id}/reviews', [WhereToEatRatingsController::class, 'create']);
    });
});
