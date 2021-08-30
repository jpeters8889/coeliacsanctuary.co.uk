<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Requests;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatTown;

class WhereToEatTownRequest extends WhereToEatCountyRequest
{
    public function rules(): array
    {
        return [];
    }

    public function resolveCountyTown(): array
    {
        $county = $this->resolveCounty();

        if ($legacy = $county->towns()->where('legacy', $this->route('town'))->first()) {
            if ($legacy->slug !== $this->route('town')) {
                redirect_now('/wheretoeat/'.$this->route('county').'/'.$legacy->slug);
            }
        }

        /** @var WhereToEatTown $town */
        $town = $county->towns()->where('slug', $this->route('town'))
            ->firstOrFail();

        return [$county, $town];
    }
}
