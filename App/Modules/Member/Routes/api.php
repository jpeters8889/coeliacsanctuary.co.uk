<?php

declare(strict_types=1);

use Coeliac\Modules\Member\Controllers\LoginController;
use Illuminate\Routing\Router;

/* @var Router $router */

if (!isset($router)) {
    return;
}

$router->group(['prefix' => 'api/member'], static function () use ($router) {
    $router->post('login', [LoginController::class, 'create']);
});
