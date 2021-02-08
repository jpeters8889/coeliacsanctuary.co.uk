<?php

declare(strict_types=1);

namespace Coeliac\Base\Middleware;

use Closure;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;

class HasVerifiedEmail extends EnsureEmailIsVerified
{
    public function handle($request, Closure $next, $redirectToRoute = null)
    {
        if (!$request->user() || !$request->user()->hasVerifiedEmail()) {
            abort(403, 'Your email address is not verified.');
        }

        return $next($request);
    }
}
