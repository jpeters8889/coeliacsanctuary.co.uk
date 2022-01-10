<?php

declare(strict_types=1);

use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatBrowseController;
use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatFeaturesController;
use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatLatLngController;
use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatRecommendAPlaceController;
use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatReportPlaceController;
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
    $router->get('/features', [WhereToEatFeaturesController::class, 'get']);
    $router->get('/ratings', [WhereToEatRatingsController::class, 'get']);

    $router->get('/browse', [WhereToEatBrowseController::class, 'list']);

    $router->post('/place-request', [WhereToEatPlaceRequestController::class, 'create']);
    $router->post('/recommend-a-place', [WhereToEatRecommendAPlaceController::class, 'create']);

    $router->post('/search', [WhereToEatSearchController::class, 'create']);

    $router->post('lat-lng', WhereToEatLatLngController::class);

    $router->group(['prefix' => '{id}'], function () use ($router) {
        $router->get('/', [WhereToEatController::class, 'get']);

        $router->post('report', [WhereToEatReportPlaceController::class, 'create']);

        $router->group(['middleware' => 'userHasNotRatedEatery'], function () use ($router) {
            $router->post('reviews', [WhereToEatRatingsController::class, 'create']);
        });
    });
});
