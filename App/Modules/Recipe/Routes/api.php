<?php

declare(strict_types=1);

use Illuminate\Routing\Router;
use Coeliac\Modules\Recipe\Controllers\RecipeController;
use Coeliac\Modules\Recipe\Controllers\RecipeMealsController;
use Coeliac\Modules\Recipe\Controllers\RecipeFeaturesController;
use Coeliac\Modules\Recipe\Controllers\RecipeAllergensController;

/* @var Router $router */

if (!isset($router)) {
    return;
}

$router->group(['prefix' => 'api/recipes'], static function () use ($router) {
    $router->get('/', [RecipeController::class, 'list']);

    $router->get('/allergens', [RecipeAllergensController::class, 'list']);
    $router->get('/features', [RecipeFeaturesController::class, 'list']);
    $router->get('/meals', [RecipeMealsController::class, 'list']);
});
