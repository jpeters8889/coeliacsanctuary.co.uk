<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\EatingOut\WhereToEat\Events\PlaceReportSubmitted;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatPlaceReport;
use Coeliac\Modules\EatingOut\WhereToEat\Requests\ReportPlace;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Http\Response;

class WhereToEatReportPlaceController extends BaseController
{
    public function create(ReportPlace $request, Dispatcher $events): Response
    {
        /** @var WhereToEatPlaceReport $placeReport */
        $placeReport = $request->eatery()->reports()->create([
            'details' => $request->input('details'),
        ]);

        $events->dispatch(new PlaceReportSubmitted($placeReport));

        return new Response(['data' => 'ok']);
    }
}
