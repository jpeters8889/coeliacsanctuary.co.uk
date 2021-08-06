<?php

declare(strict_types=1);

namespace Coeliac\Architect\Cards\PlaceReportsCard;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatPlaceReport;
use Illuminate\Http\Response;

class ApiHandler
{
    public function delete($id)
    {
        WhereToEatPlaceReport::query()->findOrFail($id)->delete();

        return new Response();
    }

    public function complete($id)
    {
        WhereToEatPlaceReport::query()->findOrFail($id)->update(['completed' => 1]);

        return new Response();
    }
}
