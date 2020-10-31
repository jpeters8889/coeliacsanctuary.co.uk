<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Events;

use Coeliac\Modules\EatingOut\WhereToEat\Models\PlaceRequest as PlaceRequestModel;

class PlaceRequestSubmitted
{
    /**
     * @var PlaceRequestModel
     */
    protected $model;

    /**
     * Create a new event instance.
     */
    public function __construct(PlaceRequestModel $placeRequest)
    {
        $this->model = $placeRequest;
    }

    public function model(): PlaceRequestModel
    {
        return $this->model;
    }
}
