<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\EatingOut\WhereToEat\Requests\WhereToEatRatingRequest;

class WhereToEatRatingsController extends BaseController
{
    public function create(WhereToEatRatingRequest $request)
    {
        $request->resolveWhereToEat()->ratings()->create([
            'rating' => $request->input('rating'),
            'ip' => $request->ip(),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'body' => $request->input('comment'),
            'method' => $request->input('method', 'website'),
            'approved' => $request->isReviewLive(),
        ]);
    }
}
