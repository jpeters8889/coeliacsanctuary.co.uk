<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\SuggestEdits;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCuisine;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatFeature;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatVenueType;
use Coeliac\Modules\EatingOut\WhereToEat\Repository;

class GetEatery
{
    protected WhereToEat $eatery;

    public function __construct(protected Repository $repository)
    {
        //
    }

    protected function resolveEatery(int $id): void
    {
        $this->eatery = $this->repository
            ->setWiths(['venueType', 'cuisine', 'openingTimes', 'features'])
            ->getOrFail($id);
    }

    public function formatData($id): array
    {
        $this->resolveEatery($id);

        return [
            'address' => $this->eatery->address,
            'website' => $this->eatery->website,
            'gf_menu_link' => $this->eatery->gf_menu_link,
            'phone' => $this->eatery->phone,
            'type_id' => $this->eatery->type_id,
            'venue_type' => $this->getVenueType(),
            'cuisine' => $this->getCuisine(),
            'opening_times' => $this->getOpeningTimes(),
            'features' => $this->getFeatures(),
            'is_nationwide' => $this->eatery->county_id === 1,
        ];
    }

    protected function getVenueType(): array
    {
        return [
            'id' => $this->eatery->venueType->id,
            'label' => $this->eatery->venueType->venue_type,
            'values' => WhereToEatVenueType::query()
                ->orderBy('venue_type')
                ->get()
                ->transform(fn (WhereToEatVenueType $venueType) => [
                    'value' => $venueType->id,
                    'label' => $venueType->venue_type,
                    'selected' => $venueType->id === $this->eatery->venueType->id,
                ]),
        ];
    }

    protected function getCuisine(): array
    {
        return [
            'id' => $this->eatery->cuisine?->id ?: null,
            'label' => $this->eatery->cuisine?->cuisine ?: null,
            'values' => WhereToEatCuisine::query()
                ->orderBy('cuisine')
                ->get()
                ->transform(fn (WhereToEatCuisine $cuisine) => [
                    'value' => $cuisine->id,
                    'label' => $cuisine->cuisine,
                    'selected' => $cuisine->id === $this->eatery->cuisine?->id,
                ]),
        ];
    }

    protected function getOpeningTimes(): ?array
    {
        if (! $this->eatery->openingTimes) {
            return null;
        }

        return [
            'today' => $this->eatery->openingTimes->is_open_now ? [$this->eatery->openingTimes->opens_at, $this->eatery->openingTimes->closes_at] : null,
            'monday' => [$this->eatery->openingTimes->monday_start, $this->eatery->openingTimes->monday_end],
            'tuesday' => [$this->eatery->openingTimes->tuesday_start, $this->eatery->openingTimes->tuesday_end],
            'wednesday' => [$this->eatery->openingTimes->wednesday_start, $this->eatery->openingTimes->wednesday_end],
            'thursday' => [$this->eatery->openingTimes->thursday_start, $this->eatery->openingTimes->thursday_end],
            'friday' => [$this->eatery->openingTimes->friday_start, $this->eatery->openingTimes->friday_end],
            'saturday' => [$this->eatery->openingTimes->saturday_start, $this->eatery->openingTimes->saturday_end],
            'sunday' => [$this->eatery->openingTimes->sunday_start, $this->eatery->openingTimes->sunday_end],
        ];
    }

    protected function getFeatures(): array
    {
        return [
            'selected' => $this->eatery->features->transform(fn (WhereToEatFeature $feature) => [
                'id' => $feature->id,
                'label' => $feature->feature,
            ]),
            'values' => WhereToEatFeature::query()
                ->orderBy('feature')
                ->get()
                ->transform(fn (WhereToEatFeature $feature) => [
                    'id' => $feature->id,
                    'label' => $feature->feature,
                    'selected' => in_array($feature->id, $this->eatery->features->pluck('id')->toArray(), true),
                ]),
        ];
    }
}
