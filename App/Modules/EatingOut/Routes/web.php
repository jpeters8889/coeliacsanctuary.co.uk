<?php

declare(strict_types=1);

use Coeliac\Modules\EatingOut\Controllers\EatingOutController;
use Illuminate\Routing\Router;

/* @var Router $router */

if (! isset($router)) {
    return;
}

$router->get('/eating-out', [EatingOutController::class, 'index']);
