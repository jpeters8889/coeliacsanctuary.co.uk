<?php

declare(strict_types=1);

namespace Coeliac\Base\Middleware;

use Closure;
use Illuminate\Container\Container;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

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
            if($request->wantsJson()) {
                return new Response([]);
            }

            return new RedirectResponse('/member/dashboard');
        }

        return $next($request);
    }
}
