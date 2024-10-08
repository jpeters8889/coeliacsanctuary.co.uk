<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Requests;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;
use Illuminate\Foundation\Http\FormRequest;

class WhereToEatCountyRequest extends FormRequest
{
    public function rules(): array
    {
        return [];
    }

    public function resolveCounty(): WhereToEatCounty
    {
        /** @var WhereToEatCounty | null $legacy */
        $legacy = WhereToEatCounty::query()->where('legacy', $this->route('county', 'nationwide'))->first();

        if ($legacy instanceof WhereToEatCounty) {
            redirect_now($this->buildRedirectUrl($legacy));
        }

        return WhereToEatCounty::query()->where('slug', $this->route('county', 'nationwide'))
            ->with('activeTowns', 'activeTowns.liveEateries', 'activeTowns.liveEateries.town')
            ->firstOrFail();
    }

    protected function buildRedirectUrl(WhereToEatCounty $county): string
    {
        return '/wheretoeat/'.$county->slug.($this->route('town') ? '/'.$this->route('town') : '');
    }
}
