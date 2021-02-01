<?php

declare(strict_types=1);

use Coeliac\Modules\Member\Controllers\LoginController;
use Illuminate\Routing\Router;

/* @var Router $router */

if (!isset($router)) {
    return;
}

$router->group(['prefix' => 'member'], static function () use ($router) {
    $router->get('login', [LoginController::class, 'show']);
});
