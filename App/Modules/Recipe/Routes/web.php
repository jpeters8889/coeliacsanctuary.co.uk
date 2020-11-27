<?php

declare(strict_types=1);

use Illuminate\Routing\Router;
use Coeliac\Modules\Recipe\Controllers\RecipeController;
use Coeliac\Modules\Recipe\Controllers\RecipeFeedController;

/* @var Router $router */

if (!isset($router)) {
    return;
}

$router->group(['prefix' => 'recipe'], static function () use ($router) {
    $router->get('/', [RecipeController::class, 'index']);
    $router->get('/feed', [RecipeFeedController::class, 'list']);
    $router->get('/{slug}', [RecipeController::class, 'show']);
    $router->get('/{slug}/print', [RecipeController::class, 'print']);
});
