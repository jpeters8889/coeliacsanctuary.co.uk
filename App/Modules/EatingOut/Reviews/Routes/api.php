<?php

declare(strict_types=1);

use Coeliac\Modules\EatingOut\Reviews\Controllers\ReviewController;
use Coeliac\Modules\EatingOut\Reviews\Controllers\ReviewCountyController;
use Coeliac\Modules\EatingOut\Reviews\Controllers\ReviewRatingController;
use Illuminate\Routing\Router;

/* @var Router $router */

if (! isset($router)) {
    return;
}

$router->group(['prefix' => 'api/reviews'], static function () use ($router) {
    $router->get('/', [ReviewController::class, 'list']);
    $router->get('counties', [ReviewCountyController::class, 'get']);
    $router->get('ratings', [ReviewRatingController::class, 'get']);
});
