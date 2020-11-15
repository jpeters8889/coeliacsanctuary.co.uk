<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;

class WhereToEatCountyRequest extends FormRequest
{
    public function rules()
    {
        return [];
    }

    public function resolveCounty()
    {
        if ($legacy = WhereToEatCounty::query()->where('legacy', $this->route('county'))->first()) {
            return redirect_now($this->buildRedirectUrl($legacy));
        }

        return WhereToEatCounty::query()->where('slug', $this->route('county'))
            ->with('activeTowns', 'activeTowns.liveEateries', 'activeTowns.liveEateries.town')
            ->firstOrFail();
    }

    protected function buildRedirectUrl(WhereToEatCounty $county): string
    {
        return '/wheretoeat/'.$county->slug.($this->route('town') ? '/'.$this->route('town') : '');
    }
}
