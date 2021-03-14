<?php

declare(strict_types=1);

use Illuminate\Routing\Router;
use Coeliac\Modules\Competition\Middleware\CompetitionIsActive;
use Coeliac\Modules\Competition\Controllers\CompetitionController;

/* @var Router $router */

if (!isset($router)) {
    return;
}

$router->group(['prefix' => 'competition', 'middleware' => CompetitionIsActive::class], static function () use ($router) {
    $router->get('{competition}', [CompetitionController::class, 'get']);
});
