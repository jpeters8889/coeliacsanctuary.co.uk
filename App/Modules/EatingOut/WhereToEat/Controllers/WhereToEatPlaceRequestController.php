<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Controllers;

use Illuminate\Http\Response;
use Illuminate\Contracts\Events\Dispatcher;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\EatingOut\WhereToEat\Requests\PlaceRequest;
use Coeliac\Modules\EatingOut\WhereToEat\Events\PlaceRequestSubmitted;
use Coeliac\Modules\EatingOut\WhereToEat\Models\PlaceRequest as PlaceRequestModel;

class WhereToEatPlaceRequestController extends BaseController
{
    /** @deprecated  */
    public function create(PlaceRequest $request, Dispatcher $events): Response
    {
        /** @var PlaceRequestModel $placeRequest */
        $placeRequest = PlaceRequestModel::query()->create([
            'name' => $request->input('name'),
            'addOrRemove' => $request->input('state'),
            'details' => $request->input('comment'),
        ]);

        $events->dispatch(new PlaceRequestSubmitted($placeRequest));

        return new Response(['data' => 'ok']);
    }
}
