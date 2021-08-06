<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Repository;
use Coeliac\Modules\EatingOut\WhereToEat\Requests\WhereToEatRatingRequest;
use Illuminate\Support\Collection;

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

    public function get(Repository $repository)
    {
        $summary = (new Collection([0,0.5,1,1.5,2,2.5,3,3.5,4,4.5,5]))
            ->mapWithKeys(function ($rating, $index) {
                return [
                    $index => [
                        'id' => $index,
                        'rating' => $rating,
                        'label' => $rating > 0 ? $rating . ' Stars' : 'No Rating',
                        'count' => 0,
                    ],
                ];
            })
            ->reverse()
            ->toArray();

        $repository
            ->filter()
            ->search()
            ->setWiths(['ratings'])
            ->all()
            ->each(function (WhereToEat $eatery) use (&$summary) {
                $rating = round((float) $eatery->average_rating * 2) / 2;
                $key = $rating * 2;

                $summary[$key]['count']++;
            });

        return array_values($summary);
    }
}
