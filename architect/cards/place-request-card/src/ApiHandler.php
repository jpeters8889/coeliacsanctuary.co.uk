<?php

declare(strict_types=1);

namespace Coeliac\Architect\Cards\PlaceRequestCard;

use Illuminate\Http\Response;
use Coeliac\Modules\EatingOut\WhereToEat\Models\PlaceRequest;

class ApiHandler
{
    public function delete($id)
    {
        PlaceRequest::query()->findOrFail($id)->delete();

        return new Response();
    }

    public function approve($id)
    {
        PlaceRequest::query()->findOrFail($id)->update(['completed' => 1]);

        return new Response();
    }
}
