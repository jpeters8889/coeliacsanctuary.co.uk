<?php

declare(strict_types=1);

use Illuminate\Routing\Router;
use Coeliac\Modules\Search\Controllers\SearchController;

/* @var Router $router */

if (!isset($router)) {
    return;
}

$router->group(['prefix' => 'api/search'], static function () use ($router) {
    $router->post('/', [SearchController::class, 'create']);
});
