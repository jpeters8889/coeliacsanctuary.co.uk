<?php

declare(strict_types=1);

namespace Coeliac\Base\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\CookieConsent\CookieConsentMiddleware as Middleware;

class CookieConsentMiddleware extends Middleware
{
    /**
     * @param Request $request
     * @param Closure $next
     *
     * @return Response
     */
    public function handle($request, Closure $next)
    {
        $excluded = [
            'cs-adm',
            'cs-adm/*',
            'mailcoach',
            'mailcoach/*',
            'horizon',
            'horizon/*',
        ];

        if ($request->is($excluded)) {
            return $next($request);
        }

        return parent::handle($request, $next);
    }
}
