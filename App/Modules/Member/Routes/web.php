<?php

declare(strict_types=1);

use Coeliac\Modules\Member\Controllers\LoginController;
use Coeliac\Modules\Member\Controllers\LogoutController;
use Coeliac\Modules\Member\Controllers\RegisterController;
use Coeliac\Modules\Member\Controllers\VerifyEmailController;
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

    $router->group(['middleware' => 'auth'], static function () use ($router) {
        $router->group(['prefix' => 'verify-email'], static function () use ($router) {
            $router->post('/', [VerifyEmailController::class, 'create']);

            $router->get('{id}/{hash}', [VerifyEmailController::class, 'show'])
                ->middleware(['signed'])
                ->name('member.verify_email');
        });

        $router->get('logout', LogoutController::class);
    });
});
