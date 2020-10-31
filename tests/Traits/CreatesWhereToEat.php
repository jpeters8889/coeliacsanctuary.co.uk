<?php

declare(strict_types=1);

namespace Tests\Traits;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatTown;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatType;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCountry;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCuisine;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatFeature;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatVenueType;

trait CreatesWhereToEat
{
    /**
     * @param array $wteParams
     *
     * @return WhereToEat
     */
    protected function createWhereToEat($wteParams = [])
    {
        $country = factory(WhereToEatCountry::class)->create();

        if (!isset($wteParams['county_id'])) {
            $county = factory(WhereToEatCounty::class)->create(['country_id' => $country->id]);
        }

        if (!isset($wteParams['town_id'])) {
            $town = factory(WhereToEatTown::class)->create(['county_id' => $county->id ?? $wteParams['county_id']]);
        }

        $venueType = factory(WhereToEatVenueType::class)->create();
        $feature = factory(WhereToEatFeature::class)->create();
        $type = factory(WhereToEatType::class)->create();
        $cuisine = factory(WhereToEatCuisine::class)->create();

        $wheretoeat = factory(WhereToEat::class)->create(array_merge([
            'country_id' => $country->id,
            'county_id' => $county->id ?? $wteParams['county_id'],
            'town_id' => $town->id ?? $wteParams['town_id'],
            'type_id' => $type->id,
            'venue_type_id' => $venueType->id,
            'cuisine_id' => $cuisine->id,
        ], $wteParams));

        $wheretoeat->features()->attach($feature);

        return $wheretoeat;
    }
}
