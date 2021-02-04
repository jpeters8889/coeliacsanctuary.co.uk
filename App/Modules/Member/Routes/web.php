<?php

declare(strict_types=1);

use Coeliac\Modules\Member\Controllers\DashboardController;
use Coeliac\Modules\Member\Controllers\Dashboards\OrdersController;
use Coeliac\Modules\Member\Controllers\Dashboards\SubscriptionsController;
use Coeliac\Modules\Member\Controllers\Dashboards\YourDetailsController;
use Coeliac\Modules\Member\Controllers\LoginController;
use Coeliac\Modules\Member\Controllers\LogoutController;
use Coeliac\Modules\Member\Controllers\RegisterController;
use Coeliac\Modules\Member\Controllers\Dashboards\ScrapbookController;
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
        $router->get('/verify-email/{id}/{hash}', [VerifyEmailController::class, 'show'])
            ->middleware(['signed'])
            ->name('member.verify_email');

        $router->get('logout', LogoutController::class);

        $router->group(['prefix' => 'dashboard'], static function () use ($router) {
            $router->get('/', [DashboardController::class, 'show']);
            $router->get('scrapbooks', [ScrapbookController::class, 'show']);
            $router->get('orders', [OrdersController::class, 'show']);
            $router->get('subscriptions', [SubscriptionsController::class, 'show']);
            $router->get('details', [YourDetailsController::class, 'show']);
        });
    });
});
