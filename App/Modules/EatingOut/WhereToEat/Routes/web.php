<?php

declare(strict_types=1);

use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatAppController;
use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatBrowseController;
use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatController;
use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatCountyController;
use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatDetailsController;
use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatNationwideController;
use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatRecommendAPlaceController;
use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatSearchController;
use Coeliac\Modules\EatingOut\WhereToEat\Controllers\WhereToEatTownController;
use Coeliac\Modules\EatingOut\WhereToEat\Middleware\BindCounty;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Router;

/* @var Router $router */

if (! isset($router)) {
    return;
}

$router->group(['prefix' => '/wheretoeat'], function () use ($router) {
    $router->get('/', [WhereToEatController::class, 'index']);
    $router->get('/nationwide', [WhereToEatNationwideController::class, 'get']);
    $router->get('/nationwide/{slug}', WhereToEatDetailsController::class);
    $router->get('/nationwide/{slug}/{branch}', WhereToEatDetailsController::class);
    $router->get('/browse', [WhereToEatBrowseController::class, 'index']);
    $router->get('/browse/{any}', [WhereToEatBrowseController::class, 'index'])->where('any', '.*');

    // Legacy
    $router->get('/map', fn () => new RedirectResponse('/wheretoeat', 301));
    $router->get('/list', fn () => new RedirectResponse('/wheretoeat', 301));
    $router->get('/place-request', fn () => new RedirectResponse('/wheretoeat/recommend-a-place', 301));

    $router->get('/recommend-a-place', [WhereToEatRecommendAPlaceController::class, 'get']);
    $router->get('/coeliac-sanctuary-on-the-go', [WhereToEatAppController::class, 'get']);

    $router->get('/search/{term}', [WhereToEatSearchController::class, 'get']);

    $router->group(['middleware' => BindCounty::class], function () use ($router) {
        $router->get('/{county}', [WhereToEatCountyController::class, 'list']);
        $router->get('/{county}/{town}', [WhereToEatTownController::class, 'list']);
        $router->get('/{county}/{town}/{slug}', WhereToEatDetailsController::class);
    });
});
