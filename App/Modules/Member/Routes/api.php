<?php

declare(strict_types=1);

use Illuminate\Routing\Router;
use Coeliac\Modules\Member\Controllers\LoginController;
use Coeliac\Modules\Member\Controllers\RegisterController;
use Coeliac\Modules\Member\Controllers\VerifyEmailController;
use Coeliac\Modules\Member\Controllers\Dashboards\OrdersController;

/* @var Router $router */

if (!isset($router)) {
    return;
}

$router->group(['prefix' => 'api/member'], static function () use ($router) {
    $router->group(['middleware' => 'guest', 'throttle:60,1'], static function () use ($router) {
        $router->post('login', [LoginController::class, 'create'])->middleware(['guest', 'throttle:60,1']);
        $router->post('register', [RegisterController::class, 'create'])->middleware(['guest', 'throttle:60,1']);
    });

    $router->group(['middleware' => 'auth'], static function () use ($router) {
        $router->post('/verify-email', [VerifyEmailController::class, 'create']);

        $router->group(['prefix' => 'dashboard'], static function () use ($router) {
            $router->group(['prefix' => 'orders', 'middleware' => ['verified']], static function () use ($router) {
                $router->get('/', [OrdersController::class, 'list'])->middleware(['verified']);
                $router->get('/{key}', [OrdersController::class, 'get']);
            });
        });
    });
});
