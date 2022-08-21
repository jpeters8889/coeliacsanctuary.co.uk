<?php

declare(strict_types=1);

use Coeliac\Modules\Competition\Controllers\CompetitionController;
use Coeliac\Modules\Competition\Middleware\CompetitionIsActive;
use Illuminate\Routing\Router;

/* @var Router $router */

if (! isset($router)) {
    return;
}

$router->group(['prefix' => 'competition', 'middleware' => CompetitionIsActive::class], static function () use ($router) {
    $router->get('{competition}', [CompetitionController::class, 'get']);
});
