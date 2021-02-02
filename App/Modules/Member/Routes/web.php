<?php

declare(strict_types=1);

use Coeliac\Modules\Member\Controllers\LoginController;
use Coeliac\Modules\Member\Controllers\RegisterController;
use Illuminate\Routing\Router;

/* @var Router $router */

if (!isset($router)) {
    return;
}

$router->group(['prefix' => 'member'], static function () use ($router) {
    $router->group(['middleware' => 'guest'], static function () use ($router) {
        $router->get('login', [LoginController::class, 'show']);
        $router->get('register', [RegisterController::class, 'show']);
    });
});
