<?php

declare(strict_types=1);

use Coeliac\Modules\Competition\Controllers\CompetitionController;
use Coeliac\Modules\Competition\Controllers\CompetitionTermsController;
use Coeliac\Modules\Competition\Middleware\CompetitionIsActive;
use Coeliac\Modules\Competition\Middleware\CompetitionIsOpenForEntries;
use Illuminate\Routing\Router;

/* @var Router $router */

if (! isset($router)) {
    return;
}

$router->group(['prefix' => 'api/competition/{competition}'], static function () use ($router) {
    $router->get('terms', CompetitionTermsController::class);

    $router->group(['middleware' => [CompetitionIsActive::class, CompetitionIsOpenForEntries::class]], static function () use ($router) {
        $router->post('/', [CompetitionController::class, 'create']);
        $router->put('/', [CompetitionController::class, 'update']);
    });
});
