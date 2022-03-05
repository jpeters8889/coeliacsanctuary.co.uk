<?php

namespace Coeliac\Modules\EatingOut\WhereToEat\Requests;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Repository;
use Illuminate\Database\Eloquent\Relations\Relation;

class WhereToEatDetailsRequest extends WhereToEatTownRequest
{

    public function resolveEatery(): WhereToEat
    {
        [, $town] = $this->resolveCountyTown();

        return resolve(Repository::class)
            ->where('town_id', $town->id)
            ->where('slug', $this->route('slug'))
            ->setWiths([
                'userReviews' => fn(Relation $relation) => $relation
                    ->where('approved', 1)
                    ->latest()
                    ->select(['id', 'wheretoeat_id', 'rating', 'name', 'price_range', 'body', 'created_at']),
                'venueType', 'cuisine', 'type', 'features', 'town', 'county', 'country', 'restaurants', 'openingTimes',
            ])
            ->firstOrFail();
    }
}
