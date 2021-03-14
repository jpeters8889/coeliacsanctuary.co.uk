<?php

declare(strict_types=1);

namespace Coeliac\Modules\Competition\Middleware;

use Closure;
use Illuminate\Http\Request;

class CompetitionIsActive
{
    public function handle(Request $request, Closure $next)
    {
        abort_if(!$request->route('competition')->isActive(), 404);

        return $next($request);
    }
}
