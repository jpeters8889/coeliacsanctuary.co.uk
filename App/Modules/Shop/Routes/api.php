<?php

declare(strict_types=1);

use Coeliac\Modules\Shop\Controllers\BasketController;
use Coeliac\Modules\Shop\Controllers\BasketDiscountController;
use Coeliac\Modules\Shop\Controllers\CountryController;
use Coeliac\Modules\Shop\Controllers\LookupController;
use Coeliac\Modules\Shop\Controllers\OrderController;
use Coeliac\Modules\Shop\Controllers\ProductController;
use Coeliac\Modules\Shop\Controllers\ProductImagesController;
use Coeliac\Modules\Shop\Controllers\ProductReviewsController;
use Coeliac\Modules\Shop\Controllers\ReviewMyOrderController;
use Coeliac\Modules\Shop\Controllers\TravelCardSearchController;
use Illuminate\Routing\Router;

/* @var Router $router */

if (! isset($router)) {
    return;
}

$router->group(['prefix' => 'api/shop'], static function () use ($router) {
    $router->group(['prefix' => 'basket'], static function () use ($router) {
        $router->get('/', [BasketController::class, 'index']);
        $router->post('/', [BasketController::class, 'create']);
        $router->put('/', [BasketController::class, 'update']);
        $router->get('summary', [BasketController::class, 'get']);
        $router->post('discount', [BasketDiscountController::class, 'create']);
    });

    $router->group(['prefix' => 'product/{id}'], static function () use ($router) {
        $router->get('/', [ProductController::class, 'get']);
        $router->get('images', [ProductImagesController::class, 'get']);
        $router->get('reviews', [ProductReviewsController::class, 'get']);
    });

    $router->get('countries', [CountryController::class, 'index']);
    $router->post('countries', [CountryController::class, 'update']);

    $router->post('lookup', [LookupController::class, 'get']);

    $router->post('order', [OrderController::class, 'create']);
    $router->patch('order', [OrderController::class, 'update']);

    $router->post('travel-card-search', [TravelCardSearchController::class, 'index']);
    $router->get('travel-card-search/{id}', [TravelCardSearchController::class, 'get']);

    $router->post('review-my-order/{invitation}', [ReviewMyOrderController::class, 'create']);
});
