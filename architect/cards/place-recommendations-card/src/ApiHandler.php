<?php

declare(strict_types=1);

namespace Coeliac\Architect\Cards\PlaceRecommendationsCard;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatRecommendation;
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
}
