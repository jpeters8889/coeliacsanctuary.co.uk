<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\EatingOut\WhereToEat\Events\PrepareWhereToEatReviewImages;
use Coeliac\Modules\EatingOut\WhereToEat\Requests\WhereToEatSubmitReviewRequest;
use Coeliac\Modules\EatingOut\WhereToEat\Support\EateryProcessors\EateryRatingsProcessor;
use Coeliac\Modules\EatingOut\WhereToEat\Support\LatestRatings;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Str;

class WhereToEatReviewsController extends BaseController
{
    public function create(WhereToEatSubmitReviewRequest $request, Dispatcher $dispatcher): void
    {
        $review = $request->resolveWhereToEat()->userReviews()->create([
            'rating' => $request->input('rating'),
            'ip' => $request->ip(),
            'name' => Str::title($request->input('name')),
            'email' => $request->input('email'),
            'food_rating' => $request->input('food'),
            'service_rating' => $request->input('service'),
            'how_expensive' => $request->input('expense'),
            'body' => $request->input('comment'),
            'admin_review' => $request->input('admin_review', false),
            'method' => $request->input('method', 'website'),
            'branch_name' => Str::title($request->input('branch_name')),
            'approved' => $request->isReviewLive(),
        ]);

        if ((! $request->isReviewLive() || $request->input('admin_review', false)) && count($request->input('images', [])) > 0) {
            $dispatcher->dispatch(new PrepareWhereToEatReviewImages($review, $request->input('images')));
        }
    }

    public function get(EateryRatingsProcessor $ratingsProcessor): array
    {
        return $ratingsProcessor->getEateries();
    }

    public function index(LatestRatings $latestRatings)
    {
        return $latestRatings->list();
    }
}
