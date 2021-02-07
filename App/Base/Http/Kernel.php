<?php

declare(strict_types=1);

namespace Coeliac\Base\Http;

use Fruitcake\Cors\HandleCors;
use Coeliac\Base\Middleware\TrimStrings;
use Coeliac\Base\Middleware\Authenticate;
use Coeliac\Base\Middleware\TrustProxies;
use Illuminate\Auth\Middleware\Authorize;
use Coeliac\Base\Middleware\EncryptCookies;
use Coeliac\Base\Middleware\VerifyCsrfToken;
use Coeliac\Base\Middleware\HasVerifiedEmail;
use Illuminate\Http\Middleware\SetCacheHeaders;
use Illuminate\Session\Middleware\StartSession;
use Coeliac\Modules\Shop\Middleware\OrderComplete;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Coeliac\Base\Middleware\CheckForMaintenanceMode;
use Coeliac\Base\Middleware\CookieConsentMiddleware;
use Coeliac\Base\Middleware\RedirectIfAuthenticated;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Routing\Middleware\ValidateSignature;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Coeliac\Modules\EatingOut\WhereToEat\Middleware\UserHasNotRatedEatery;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        CheckForMaintenanceMode::class,
        ValidatePostSize::class,
        TrimStrings::class,
        ConvertEmptyStringsToNull::class,
        TrustProxies::class,
        HandleCors::class,
        CookieConsentMiddleware::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            ShareErrorsFromSession::class,
            VerifyCsrfToken::class,
            SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => Authenticate::class,
        'auth.basic' => AuthenticateWithBasicAuth::class,
        'bindings' => SubstituteBindings::class,
        'cache.headers' => SetCacheHeaders::class,
        'can' => Authorize::class,
        'csrf' => VerifyCsrfToken::class,
        'guest' => RedirectIfAuthenticated::class,
        'signed' => ValidateSignature::class,
        'throttle' => ThrottleRequests::class,
        'verified' => HasVerifiedEmail::class,

        'userHasNotRatedEatery' => UserHasNotRatedEatery::class,
        'shopOrderComplete' => OrderComplete::class,
    ];
}
