<?php

namespace Coeliac\Modules\EatingOut\WhereToEat\Middleware;

use Closure;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;
use Coeliac\Modules\EatingOut\WhereToEat\Requests\WhereToEatCountyRequest;
use Illuminate\Container\Container;
use Illuminate\Http\Request;

class BindCounty
{
    public function handle(Request $request, Closure $next)
    {
        Container::getInstance()->instance(WhereToEatCounty::class, $this->resolveCounty($request));

        return $next($request);
    }

    public function resolveCounty(Request $request)
    {
        if ($legacy = WhereToEatCounty::query()->where('legacy', $request->route('county'))->first()) {
            return redirect_now($this->buildRedirectUrl($legacy, $request));
        }

        return WhereToEatCounty::query()->where('slug', $request->route('county'))
            ->with('activeTowns', 'activeTowns.liveEateries', 'activeTowns.liveEateries.town')
            ->firstOrFail();
    }

    protected function buildRedirectUrl(WhereToEatCounty $county, Request $request): string
    {
        return '/wheretoeat/'.$county->slug.($request->route('town') ? '/'.$request->route('town') : '');
    }
}
