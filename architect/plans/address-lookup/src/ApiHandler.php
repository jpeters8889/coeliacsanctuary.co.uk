<?php

declare(strict_types=1);

namespace Coeliac\Architect\Plans\AddressLookup;

use Illuminate\Http\Request;
use Spatie\Geocoder\Geocoder;

class ApiHandler
{
    public function lookup(Request $request, Geocoder $geocoder)
    {
        $geocoder->setApiKey(config('services.google.maps.admin'));

        return $geocoder->getCoordinatesForAddress($request->input('address'));
    }
}
