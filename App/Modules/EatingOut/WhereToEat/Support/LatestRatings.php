<?php

namespace Coeliac\Modules\EatingOut\WhereToEat\Support;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatReview;
use Illuminate\Support\Collection;

class LatestRatings
{
    public function list(): Collection
    {
        return WhereToEatReview::query()
            ->with(['eatery', 'eatery.country', 'eatery.county', 'eatery.town'])
            ->latest()
            ->take(5)
            ->get()
            ->transform(fn (WhereToEatReview $rating) => [
                'id' => $rating->id,
                'slug' => "/wheretoeat/{$rating->eatery->county->slug}/{$rating->eatery->town->slug}/{$rating->eatery->slug}",
                'town' => "/wheretoeat/{$rating->eatery->county->slug}/{$rating->eatery->town->slug}",
                'name' => $rating->eatery->name,
                'location' => $rating->eatery->full_name,
                'full_location' => $rating->eatery->full_location,
                'rating' => $rating->rating,
                'created_at' => $rating->created_at->diffForHumans(),
            ]);
    }
}
