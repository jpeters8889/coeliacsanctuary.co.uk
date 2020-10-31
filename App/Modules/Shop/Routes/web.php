<?php

declare(strict_types=1);

use Illuminate\Routing\Router;
use Coeliac\Modules\Shop\Controllers\BasketController;
use Coeliac\Modules\Shop\Controllers\ProductController;
use Coeliac\Modules\Shop\Controllers\CategoryController;
use Coeliac\Modules\Shop\Controllers\BasketDoneController;

/* @var Router $router */

if (!isset($router)) {
    return;
}

$router->group(['prefix' => 'shop'], static function () use ($router) {
    $router->get('/', [CategoryController::class, 'index']);
    $router->get('basket', [BasketController::class, 'show']);

    $router->group(['middleware' => 'shopOrderComplete'], static function () use ($router) {
        $router->get('/basket/done', [BasketDoneController::class, 'show']);
    });

    $router->get('product/{slug}', [ProductController::class, 'show']);
    $router->get('{slug}', [CategoryController::class, 'show']);
});
