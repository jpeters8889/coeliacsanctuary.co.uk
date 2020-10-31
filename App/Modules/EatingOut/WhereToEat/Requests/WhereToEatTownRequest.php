<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Requests;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatTown;

class WhereToEatTownRequest extends WhereToEatCountyRequest
{
    public function rules()
    {
        return [];
    }

    public function resolveCountyTown()
    {
        $county = $this->resolveCounty();

        /** @var WhereToEatTown $town */
        $town = $county->towns()->where('slug', $this->route('town'))
            ->firstOrFail();

        return [$county, $town];
    }
}
