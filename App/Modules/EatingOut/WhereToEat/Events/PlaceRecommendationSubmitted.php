<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Events;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatRecommendation;

class PlaceRecommendationSubmitted
{
    protected WhereToEatRecommendation $model;

    public function __construct(WhereToEatRecommendation $placeRecommendation)
    {
        $this->model = $placeRecommendation;
    }

    public function model(): WhereToEatRecommendation
    {
        return $this->model;
    }
}
