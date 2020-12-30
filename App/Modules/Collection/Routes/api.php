<?php

declare(strict_types=1);

use Illuminate\Routing\Router;
use Coeliac\Modules\Collection\Controllers\CollectionController;

/* @var Router $router */

if (!isset($router)) {
    return;
}

$router->group(['prefix' => 'api/collection'], static function () use ($router) {
    $router->get('/', [CollectionController::class, 'list']);
});
