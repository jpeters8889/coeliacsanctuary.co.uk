<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Controllers;

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Exception;
use Illuminate\Http\Response;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Shop\PostcodeLookup\Service;
use Coeliac\Modules\Shop\Requests\PostcodeLookupRequest;

class LookupController extends BaseController
{
    public function get(PostcodeLookupRequest $request, Service $postcodeService)
    {
        try {
            return [
                'data' => $postcodeService->lookup($request->input('postcode')),
            ];
        } catch (Exception $exception) {
            Bugsnag::notifyException($exception);
            return new Response(['error' => "Couldn't lookup postcode"], 400);
        }
    }
}
