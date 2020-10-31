<?php

declare(strict_types=1);

use Illuminate\Routing\Router;
use Coeliac\Modules\EatingOut\Reviews\Controllers\ReviewController;
use Coeliac\Modules\EatingOut\Reviews\Controllers\ReviewFeedController;

/* @var Router $router */

if (!isset($router)) {
    return;
}

$router->group(['prefix' => '/review'], function () use ($router) {
    $router->get('/', [ReviewController::class, 'index']);
    $router->get('/feed', [ReviewFeedController::class, 'list']);
    $router->get('/{slug}', [ReviewController::class, 'show']);
});
