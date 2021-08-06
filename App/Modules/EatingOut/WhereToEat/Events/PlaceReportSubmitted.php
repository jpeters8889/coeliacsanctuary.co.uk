<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Events;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatPlaceReport;

class PlaceReportSubmitted
{
    /**
     * @var WhereToEatPlaceReport
     */
    protected $model;

    /**
     * Create a new event instance.
     */
    public function __construct(WhereToEatPlaceReport $placeRequest)
    {
        $this->model = $placeRequest;
    }

    public function model(): WhereToEatPlaceReport
    {
        return $this->model;
    }
}
