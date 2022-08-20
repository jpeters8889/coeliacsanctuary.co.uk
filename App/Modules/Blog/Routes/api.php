<?php

declare(strict_types=1);

use Coeliac\Modules\Blog\Controllers\BlogController;
use Coeliac\Modules\Blog\Controllers\BlogTagController;
use Coeliac\Modules\Blog\Controllers\BlogYearController;
use Illuminate\Routing\Router;

/* @var Router $router */

if (! isset($router)) {
    return;
}

$router->group(['prefix' => 'api/blogs'], static function () use ($router) {
    $router->get('/', [BlogController::class, 'list']);

    $router->get('/tags', [BlogTagController::class, 'list']);

    $router->get('/years', [BlogYearController::class, 'list']);
});
