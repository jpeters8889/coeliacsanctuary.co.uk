<?php

declare(strict_types=1);

use Illuminate\Routing\Router;
use Coeliac\Modules\Member\Controllers\LoginController;
use Coeliac\Modules\Member\Controllers\LogoutController;
use Coeliac\Modules\Member\Controllers\RegisterController;
use Coeliac\Modules\Member\Controllers\DashboardController;
use Coeliac\Modules\Member\Controllers\VerifyEmailController;
use Coeliac\Modules\Member\Controllers\ManageUpdatesController;
use Coeliac\Modules\Member\Controllers\ResetPasswordController;
use Coeliac\Modules\Member\Controllers\ForgotPasswordController;
use Coeliac\Modules\Member\Controllers\Dashboards\OrdersController;
use Coeliac\Modules\Member\Controllers\Dashboards\ScrapbookController;
use Coeliac\Modules\Member\Controllers\Dashboards\YourDetailsController;
use Coeliac\Modules\Member\Controllers\Dashboards\DailyUpdatesController;

/* @var Router $router */

if (!isset($router)) {
    return;
}

$router->group(['prefix' => 'member'], static function () use ($router) {
    $router->group(['middleware' => 'guest'], static function () use ($router) {
        $router->get('login', [LoginController::class, 'show']);
        $router->get('register', [RegisterController::class, 'show']);

        $router->get('forgot-password', [ForgotPasswordController::class, 'show']);
        $router->get('reset-password/{token}', [ResetPasswordController::class, 'show']);
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
            $router->get('daily-updates', [DailyUpdatesController::class, 'show']);
            $router->get('details', [YourDetailsController::class, 'show']);
        });
    });

    $router->get('/manage-daily-updates/{id}/{hash}', ManageUpdatesController::class)
        ->middleware(['signed'])
        ->name('member.manage_updates');
});
