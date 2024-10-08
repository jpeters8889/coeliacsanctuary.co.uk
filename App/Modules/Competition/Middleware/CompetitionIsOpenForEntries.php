<?php

declare(strict_types=1);

namespace Coeliac\Modules\Competition\Middleware;

use Closure;
use Coeliac\Modules\Competition\Models\Competition;
use Illuminate\Http\Request;

class CompetitionIsOpenForEntries
{
    public function handle(Request $request, Closure $next): mixed
    {
        /** @var Competition $competition */
        $competition = $request->route('competition');

        abort_if(! $competition->isOpenForEntries(), 404);

        return $next($request);
    }
}
