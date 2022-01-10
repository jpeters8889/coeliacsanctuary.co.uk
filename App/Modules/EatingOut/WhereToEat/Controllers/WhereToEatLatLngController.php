<?php

namespace Coeliac\Modules\EatingOut\WhereToEat\Controllers;

use Coeliac\Modules\EatingOut\WhereToEat\Requests\QuickSearchRequest;
use Spatie\Geocoder\Geocoder;

class WhereToEatLatLngController
{
    public function __invoke(QuickSearchRequest $request, Geocoder $geocoder): array
    {
        $search = $geocoder->getCoordinatesForAddress($request->input('term'));

        return [
            'lat' => $search['lat'],
            'lng' => $search['lng'],
        ];
    }
}
