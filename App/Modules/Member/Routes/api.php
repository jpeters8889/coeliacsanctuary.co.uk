<?php

declare(strict_types=1);

use Coeliac\Modules\Member\Controllers\Dashboards\ScrapbookItemController;
use Illuminate\Routing\Router;
use Coeliac\Modules\Member\Controllers\LoginController;
use Coeliac\Modules\Member\Controllers\AddressController;
use Coeliac\Modules\Member\Controllers\RegisterController;
use Coeliac\Modules\Member\Controllers\VerifyEmailController;
use Coeliac\Modules\Member\Controllers\Dashboards\OrdersController;
use Coeliac\Modules\Member\Controllers\Dashboards\ScrapbookController;
use Coeliac\Modules\Member\Controllers\Dashboards\YourDetailsController;

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
        $router->group(['prefix' => 'addresses', 'middleware' => ['verified']], static function () use ($router) {
            $router->get('/', [AddressController::class, 'list']);
            $router->post('{address}', [AddressController::class, 'update']);
            $router->delete('{address}', [AddressController::class, 'delete']);
        });

        $router->post('/verify-email', [VerifyEmailController::class, 'create']);

        $router->group(['prefix' => 'dashboard'], static function () use ($router) {
            $router->group(['prefix' => 'orders', 'middleware' => ['verified']], static function () use ($router) {
                $router->get('/', [OrdersController::class, 'list']);
                $router->get('/{key}', [OrdersController::class, 'get']);
            });

            $router->group(['prefix' => 'details'], static function () use ($router) {
                $router->post('/', [YourDetailsController::class, 'update']);
                $router->patch('/', [YourDetailsController::class, 'password']);
            });

            $router->group(['prefix' => 'scrapbooks'], static function () use ($router) {
                $router->get('/', [ScrapbookController::class, 'list']);
                $router->post('/', [ScrapbookController::class, 'create']);

                $router->group(['prefix' => '{scrapbook}'], static function () use ($router) {
                    $router->post('/', [ScrapbookItemController::class, 'create']);
                    $router->patch('/', [ScrapbookController::class, 'update']);
                    $router->delete('/', [ScrapbookController::class, 'delete']);

                    $router->delete('{item}', [ScrapbookItemController::class, 'delete']);
                });
            });
        });
    });
});
