<?php

declare(strict_types=1);

use Coeliac\Modules\Member\Controllers\LoginController;
use Coeliac\Modules\Member\Controllers\RegisterController;
use Illuminate\Routing\Router;

/* @var Router $router */

if (!isset($router)) {
    return;
}

$router->group(['prefix' => 'api/member'], static function () use ($router) {
    $router->post('login', [LoginController::class, 'create'])->middleware(['guest', 'throttle:60,1']);
    $router->post('register', [RegisterController::class, 'create'])->middleware(['guest', 'throttle:60,1']);
});
