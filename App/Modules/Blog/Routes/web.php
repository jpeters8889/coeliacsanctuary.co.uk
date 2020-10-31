<?php

declare(strict_types=1);

use Illuminate\Routing\Router;
use Coeliac\Modules\Blog\Controllers\BlogController;
use Coeliac\Modules\Blog\Controllers\BlogFeedController;

/* @var Router $router */

if (!isset($router)) {
    return;
}

$router->group(['prefix' => 'blog'], static function () use ($router) {
    $router->get('/', [BlogController::class, 'index']);
    $router->get('/feed', [BlogFeedController::class, 'list']);
    $router->get('/{slug}', [BlogController::class, 'show']);
});
