<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;

class UserHasNotRatedEatery
{
    public function handle(Request $request, Closure $next): mixed
    {
        /** @var WhereToEat $eatery */
        $eatery = WhereToEat::query()->findOrFail($request->route('id'));

        if ($eatery->userReviews()->where('ip', $request->ip())->count() > 0) {
//            return new Response(['error' => 'You have already rated this location'], 422);
        }

        return $next($request);
    }
}
