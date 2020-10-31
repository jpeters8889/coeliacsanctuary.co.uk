<?php

declare(strict_types=1);

use Illuminate\Routing\Router;
use Coeliac\Modules\EatingOut\Controllers\EatingOutController;

/* @var Router $router */

if (!isset($router)) {
    return;
}

$router->get('/eating-out', [EatingOutController::class, 'index']);
