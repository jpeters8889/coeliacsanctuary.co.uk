<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Middleware;

use Closure;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;
use Illuminate\Container\Container;
use Illuminate\Http\Request;

class BindCounty
{
    public function handle(Request $request, Closure $next): mixed
    {
        Container::getInstance()->instance(WhereToEatCounty::class, $this->resolveCounty($request));

        return $next($request);
    }

    public function resolveCounty(Request $request): WhereToEatCounty
    {
        /** @var WhereToEatCounty $legacy */
        $legacy = WhereToEatCounty::query()->where('legacy', $request->route('county'))->first();

        if ($legacy instanceof WhereToEatCounty) {
            redirect_now($this->buildRedirectUrl($legacy, $request));
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
