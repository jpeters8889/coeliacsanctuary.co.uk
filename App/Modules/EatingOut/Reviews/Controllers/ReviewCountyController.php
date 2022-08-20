<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\Reviews\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;

class ReviewCountyController extends BaseController
{
    public function get(): array
    {
        $counties = [];

        WhereToEatCounty::query()
            ->with('country')
            ->whereHas('reviews')
            ->withCount('reviews')
            ->get()
            ->each(function (WhereToEatCounty $county) use (&$counties) {
                if (! isset($counties[$county->country->country])) {
                    $counties[$county->country->country] = [];
                }

                $counties[$county->country->country][$county->county] = $county->reviews_count;
            });

        ksort($counties);

        return ['data' => $counties];
    }
}
