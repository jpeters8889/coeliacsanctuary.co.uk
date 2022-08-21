<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Support;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatReview;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class LatestRatings
{
    protected function eateryLink(WhereToEat $eatery): string
    {
        if (Str::lower($eatery->town->town) === 'nationwide') {
            return "/wheretoeat/nationwide/{$eatery->slug}";
        }

        return "/wheretoeat/{$eatery->county->slug}/{$eatery->town->slug}/{$eatery->slug}";
    }

    protected function townLink(WhereToEat $eatery): string
    {
        if (Str::lower($eatery->town->town) === 'nationwide') {
            return '/wheretoeat/nationwide';
        }

        return "/wheretoeat/{$eatery->county->slug}/{$eatery->town->slug}";
    }

    /** @return Collection<int, array{id: int, eatery_id: int, slug: string, town: string, name: mixed, location: string|null, full_location: string|null, rating: mixed, created_at: string}> */
    public function list(): Collection
    {
        return WhereToEatReview::query()
            ->with(['eatery', 'eatery.country', 'eatery.county', 'eatery.town'])
            ->whereRelation('eatery', 'live', true)
            ->latest()
            ->take(5)
            ->get()
            ->map(fn (WhereToEatReview $rating) => [ //@phpstan-ignore-line
                'id' => $rating->id,
                'eatery_id' => $rating->wheretoeat_id,
                'slug' => $this->eateryLink($rating->eatery),
                'town' => $this->townLink($rating->eatery),
                'name' => $rating->eatery->name,
                'location' => $rating->eatery->full_name,
                'full_location' => $rating->eatery->full_location,
                'rating' => $rating->rating,
                'created_at' => $rating->created_at->diffForHumans(),
            ]);
    }
}
