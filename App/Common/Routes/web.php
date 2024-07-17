<?php

declare(strict_types=1);

use Coeliac\Common\Controllers\AboutUsController;
use Coeliac\Common\Controllers\ContactController;
use Coeliac\Common\Controllers\CookiePolicyController;
use Coeliac\Common\Controllers\EmailController;
use Coeliac\Common\Controllers\FaqController;
use Coeliac\Common\Controllers\FeedController;
use Coeliac\Common\Controllers\HomepageController;
use Coeliac\Common\Controllers\PrivacyPolicyController;
use Coeliac\Common\Controllers\SiteMapController;
use Coeliac\Common\Controllers\TermsOfUseController;
use Coeliac\Common\Controllers\WorkWithUsController;
use Coeliac\Common\Controllers\WteImportController;
use Coeliac\Common\Controllers\WteSearchController;
use Illuminate\Routing\Router;
use JPeters\Architect\Http\Middleware\Authenticate;
use JPeters\Architect\Http\Middleware\CanAccessArchitect;

/* @var Router $router */

if (! isset($router)) {
    return;
}

$router->get('/', [HomepageController::class, 'handle']);
$router->get('about', [AboutUsController::class, 'get']);
$router->get('contact', [ContactController::class, 'get']);
$router->get('cookie-policy', [CookiePolicyController::class, 'get']);
$router->get('faq', [FaqController::class, 'get']);
$router->get('email/{key}', [EmailController::class, 'get']);
$router->get('privacy-policy', [PrivacyPolicyController::class, 'get']);
$router->get('terms-of-use', [TermsOfUseController::class, 'get']);
$router->get('work-with-us', [WorkWithUsController::class, 'get']);

$router->get('feed', FeedController::class);

$router->get('sitemap.xml', [SiteMapController::class, 'get']);


$router->get('wte-csv-import', [WteImportController::class, 'get'])->middleware([Authenticate::class, CanAccessArchitect::class]);
$router->post('wte-csv-import/process', [WteImportController::class, 'process'])->middleware([Authenticate::class, CanAccessArchitect::class]);
$router->post('wte-csv-import/process/add', [WteImportController::class, 'add'])->middleware([Authenticate::class, CanAccessArchitect::class]);

$router->get('wte-csv-search', [WteSearchController::class, 'get'])->middleware([Authenticate::class, CanAccessArchitect::class]);
$router->post('wte-csv-search/process', [WteSearchController::class, 'process'])->middleware([Authenticate::class, CanAccessArchitect::class]);
$router->post('wte-csv-search/process/download', [WteSearchController::class, 'download'])->middleware([Authenticate::class, CanAccessArchitect::class]);
