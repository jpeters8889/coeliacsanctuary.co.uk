<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\Reviews\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Config\Repository as ConfigRepository;

class ReviewCountyController extends BaseController
{
    public function get(CacheRepository $cacheRepository, ConfigRepository $configRepository)
    {
        $counties = [];

        WhereToEatCounty::query()
            ->with('country')
            ->whereHas('reviews')
            ->withCount('reviews')
            ->get()
            ->each(function (WhereToEatCounty $county) use (&$counties) {
                if (!isset($counties[$county->country->country])) {
                    $counties[$county->country->country] = [];
                }

                $counties[$county->country->country][$county->county] = $county->reviews_count;
            });

        ksort($counties);

        return ['data' => $counties];
    }
}
