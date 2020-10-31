<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\Reviews\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\EatingOut\Reviews\Repository;
use Coeliac\Modules\EatingOut\Reviews\Models\Review;

class ReviewRatingController extends BaseController
{
    public function get(Repository $repository)
    {
        $ratings = [];

        for ($rating = 5; $rating >= 0; --$rating) {
            if ($rating < 5) {
                $ratings["{$rating}.5"] = 0;
            }

            $ratings["{$rating}.0"] = 0;
        }

        $repository
            ->setWiths([])
            ->all()
            ->each(function (Review $review) use (&$ratings) {
                ++$ratings[$review->overall_rating];
            });

        return ['data' => $ratings];
    }
}
