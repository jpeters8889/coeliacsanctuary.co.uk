<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Middleware;

use Closure;
use Coeliac\Modules\Member\Contracts\UserActivityMonitor;
use Illuminate\Http\Request;

class LogUserActivity
{
    public function __construct(private UserActivityMonitor $activityMonitor)
    {
    }

    public function handle(Request $request, Closure $next): mixed
    {
        if (! $request->user()) {
            return $next($request);
        }

        $this->activityMonitor->mark($request->user());

        return $next($request);
    }
}
