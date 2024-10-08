<?php

declare(strict_types=1);

use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatBrowseController;
use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatController;
use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatFeaturesController;
use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatLatestPlacesController;
use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatLatLngController;
use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatPlaceRequestController;
use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatRecommendAPlaceController;
use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatRecommendAPlaceLookupController;
use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatReportPlaceController;
use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatReviewImageUploadController;
use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatReviewsController;
use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatSearchController;
use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatSuggestEditController;
use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatSummaryController;
use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatVenueTypesController;
use Illuminate\Routing\Router;

/* @var Router $router */

if (! isset($router)) {
    return;
}

$router->group(['prefix' => '/api/wheretoeat'], function () use ($router) {
    $router->get('/', [WhereToEatController::class, 'list']);
    $router->get('latest', WhereToEatLatestPlacesController::class);
    $router->get('summary', [WhereToEatSummaryController::class, 'get']);
    $router->get('venueTypes', [WhereToEatVenueTypesController::class, 'get']);
    $router->get('features', [WhereToEatFeaturesController::class, 'get']);
    $router->get('ratings', [WhereToEatReviewsController::class, 'get']);
    $router->get('ratings/latest', [WhereToEatReviewsController::class, 'index']);

    $router->get('browse', [WhereToEatBrowseController::class, 'list']);

    $router->post('place-request', [WhereToEatPlaceRequestController::class, 'create']);
    $router->post('recommend-a-place', [WhereToEatRecommendAPlaceController::class, 'create']);
    $router->post('recommend-a-place/lookup', WhereToEatRecommendAPlaceLookupController::class);

    $router->post('review/image-upload', WhereToEatReviewImageUploadController::class);

    $router->post('search', [WhereToEatSearchController::class, 'create']);

    $router->post('lat-lng', WhereToEatLatLngController::class);

    $router->group(['prefix' => '{id}'], function () use ($router) {
        $router->get('/', [WhereToEatController::class, 'get']);

        $router->post('report', [WhereToEatReportPlaceController::class, 'create']);

        $router->get('suggest-edit', [WhereToEatSuggestEditController::class, 'get']);
        $router->post('suggest-edit', [WhereToEatSuggestEditController::class, 'update']);

        $router->group(['middleware' => 'userHasNotRatedEatery'], function () use ($router) {
            $router->post('reviews', [WhereToEatReviewsController::class, 'create']);
        });
    });
});
