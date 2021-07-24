<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Middleware;

use Closure;
use Illuminate\Http\Request;
use Coeliac\Modules\Member\Contracts\UserActivityMonitor;

class LogUserActivity
{
    private UserActivityMonitor $activityMonitor;

    public function __construct(UserActivityMonitor $activityMonitor)
    {
        $this->activityMonitor = $activityMonitor;
    }

    public function handle(Request $request, Closure $next)
    {
        if (!$request->user()) {
            return $next($request);
        }

        $this->activityMonitor->mark($request->user());

        return $next($request);
    }
}
