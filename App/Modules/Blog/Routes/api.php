<?php

declare(strict_types=1);

use Illuminate\Routing\Router;
use Coeliac\Modules\Blog\Controllers\BlogController;
use Coeliac\Modules\Blog\Controllers\BlogTagController;
use Coeliac\Modules\Blog\Controllers\BlogYearController;

/* @var Router $router */

if (!isset($router)) {
    return;
}

$router->group(['prefix' => 'api/blogs'], static function () use ($router) {
    $router->get('/', [BlogController::class, 'list']);

    $router->get('/tags', [BlogTagController::class, 'list']);

    $router->get('/years', [BlogYearController::class, 'list']);
});
