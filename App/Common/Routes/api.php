<?php

declare(strict_types=1);

use Coeliac\Common\Controllers\CommentController;
use Coeliac\Common\Controllers\ContactController;
use Coeliac\Common\Controllers\NavigationController;
use Coeliac\Common\Controllers\NewsletterController;
use Coeliac\Common\Controllers\PopupController;
use Coeliac\Common\Controllers\RenderMjmlController;
use Coeliac\Common\Controllers\TokenController;
use Illuminate\Routing\Router;

/* @var Router $router */

if (! isset($router)) {
    return;
}

$router->group(['prefix' => 'api'], static function () use ($router) {
    $router->group(['prefix' => 'comments'], static function () use ($router) {
        $router->post('/', [CommentController::class, 'store']);

        $router->get('/{area}/{id}', [CommentController::class, 'get']);
    });

    $router->post('contact', [ContactController::class, 'store']);
    $router->get('navigation', [NavigationController::class, 'get']);

    $router->group(['prefix' => 'popup'], static function () use ($router) {
        $router->get('', [PopupController::class, 'get']);
        $router->patch('{id}', [PopupController::class, 'update']);
    });

    $router->get('app-request-token', [TokenController::class, 'get']);

    $router->group(['prefix' => 'newsletter'], static function () use ($router) {
        $router->post('', [NewsletterController::class, 'store']);
        $router->post('render-mjml', [RenderMjmlController::class, 'get'])->middleware('auth');
    });
});
