<?php

declare(strict_types=1);

use Coeliac\Modules\Info\Controllers\InfoController;
use Illuminate\Routing\Router;

/* @var Router $router */

if (! isset($router)) {
    return;
}

$router->group(['prefix' => 'info'], static function () use ($router) {
    $router->get('/', [InfoController::class, 'index']);
    $router->get('/coeliac', [InfoController::class, 'coeliacInfo']);
    $router->get('/shopping-list', [InfoController::class, 'shoppingList']);
    $router->get('/storecupboard-check', [InfoController::class, 'storecupboard']);
    $router->get('/gluten-challenge', [InfoController::class, 'glutenChallenge']);
});
