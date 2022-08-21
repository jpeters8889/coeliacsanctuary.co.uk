<?php

declare(strict_types=1);

use Coeliac\Modules\Blog\Controllers\BlogController;
use Coeliac\Modules\Blog\Controllers\BlogFeedController;
use Illuminate\Routing\Router;

/* @var Router $router */

if (! isset($router)) {
    return;
}

$router->group(['prefix' => 'blog'], static function () use ($router) {
    $router->get('/', [BlogController::class, 'index']);
    $router->get('/feed', [BlogFeedController::class, 'list']);
    $router->get('/{slug}', [BlogController::class, 'show']);
});
