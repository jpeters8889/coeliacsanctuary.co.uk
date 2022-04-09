<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\EatingOut\WhereToEat\Events\PrepareWhereToEatReviewImages;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Repository;
use Coeliac\Modules\EatingOut\WhereToEat\Requests\WhereToEatRatingRequest;
use Coeliac\Modules\EatingOut\WhereToEat\Support\LatestRatings;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Collection;

class WhereToEatReviewsController extends BaseController
{
    public function create(WhereToEatRatingRequest $request, Dispatcher $dispatcher): void
    {
        $review = $request->resolveWhereToEat()->userReviews()->create([
            'rating' => $request->input('rating'),
            'ip' => $request->ip(),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'food_rating' => $request->input('food'),
            'service_rating' => $request->input('service'),
            'how_expensive' => $request->input('expense'),
            'body' => $request->input('comment'),
            'method' => $request->input('method', 'website'),
            'approved' => $request->isReviewLive(),
        ]);

        if (!$request->isReviewLive() && count($request->input('images', [])) > 0) {
            $dispatcher->dispatch(new PrepareWhereToEatReviewImages($review, $request->input('images')));
        }
    }

    public function get(Repository $repository): array
    {
        $summary = (new Collection([0, 0.5, 1, 1.5, 2, 2.5, 3, 3.5, 4, 4.5, 5]))
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
            ->setWiths(['userReviews'])
            ->all()
            ->each(function (WhereToEat $eatery) use (&$summary) {
                $rating = round((float)$eatery->average_rating * 2) / 2;
                $key = $rating * 2;

                $summary[$key]['count']++;
            });

        return array_values($summary);
    }

    public function index(LatestRatings $latestRatings)
    {
        return $latestRatings->list();
    }
}
