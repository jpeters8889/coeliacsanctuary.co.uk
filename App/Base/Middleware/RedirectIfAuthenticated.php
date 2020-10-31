<?php

declare(strict_types=1);

namespace Coeliac\Base\Middleware;

use Closure;
use Illuminate\Container\Container;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponse;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param string|null              $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Container::getInstance()->make(Guard::class)->check()) {
            return new RedirectResponse('/');
        }

        return $next($request);
    }
}
