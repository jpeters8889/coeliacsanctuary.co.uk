<?php

declare(strict_types=1);

namespace Coeliac\Modules\Competition\Middleware;

use Closure;
use Illuminate\Http\Request;

class CompetitionIsOpenForEntries
{
    public function handle(Request $request, Closure $next)
    {
        abort_if(!$request->route('competition')->isOpenForEntries(), 404);

        return $next($request);
    }
}
