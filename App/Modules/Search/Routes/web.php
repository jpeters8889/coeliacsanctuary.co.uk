<?php

declare(strict_types=1);

use Illuminate\Routing\Router;
use Coeliac\Modules\Search\Controllers\SearchController;

/* @var Router $router */

if (!isset($router)) {
    return;
}

$router->group(['prefix' => 'search'], static function () use ($router) {
    $router->get('/', [SearchController::class, 'get']);
});
