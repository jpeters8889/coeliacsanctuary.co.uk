<?php

declare(strict_types=1);

namespace Coeliac\Architect\Cards\PlaceRecommendationsCard;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatRecommendation;
use Exception;
use Illuminate\Http\Response;

class ApiHandler
{
    public function delete($id)
    {
        WhereToEatRecommendation::query()->findOrFail($id)->delete();

        return new Response();
    }

    public function complete($id)
    {
        WhereToEatRecommendation::query()->findOrFail($id)->update(['completed' => 1]);

        return new Response();
    }

    public function convert($id)
    {
        /** @var WhereToEatRecommendation $recommendation */
        $recommendation = WhereToEatRecommendation::query()->findOrFail($id);

        try {
            $eatery = WhereToEat::query()->create([
                'name' => $recommendation->place_name,
                'town_id' => 529,
                'county_id' => 1,
                'country_id' => 1,
                'info' => $recommendation->place_details,
                'address' => $recommendation->place_location,
                'lat' => 0,
                'lng' => 0,
                'website' => $recommendation->place_web_address,
                'type_id' => 1,
                'venue_type_id' => $recommendation->place_venue_type_id,
                'cuisine_id' => 1,
                'live' => 0,
            ]);

            $recommendation->update(['completed' => 1]);

            return new Response([
                'error' => false,
                'id' => $eatery->id,
            ]);
        } catch (Exception $exception) {
            return new Response([
                'error' => true,
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
