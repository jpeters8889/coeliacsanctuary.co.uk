<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Requests;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatReview;
use Coeliac\Modules\EatingOut\WhereToEat\Repository;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Relation;

class WhereToEatDetailsRequest extends WhereToEatTownRequest
{
    public function resolveEatery(): WhereToEat
    {
        [, $town] = $this->resolveCountyTown();

        /** @var WhereToEat $eatery */
        $eatery = resolve(Repository::class)
            ->where('town_id', $town->id)
            ->where('slug', $this->route('slug'))
            ->setWiths([
                'userReviews' => fn (HasMany $relation) => $relation
                    ->where('approved', 1)
                    ->with('images')
                    ->latest()
                    ->select([
                        'id', 'wheretoeat_id', 'rating', 'name', 'food_rating', 'admin_review',
                        'service_rating', 'how_expensive', 'body', 'created_at', 'branch_name',
                    ]),
                'userImages' => fn (HasMany $relation) => $relation->latest()->whereRelation('review', 'approved', 1),
                'venueType', 'cuisine', 'type', 'features', 'town', 'county', 'country', 'restaurants', 'openingTimes',
            ])
            ->firstOrFail();

        /** @phpstan-ignore-next-line  */
        $eatery->formattedReviews = $eatery->userReviews
            ->groupBy(fn (WhereToEatReview $review) => $review->admin_review ? 'admin' : 'guest');

        return $eatery;
    }
}
