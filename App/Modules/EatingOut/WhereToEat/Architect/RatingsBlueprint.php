<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Architect;

use Illuminate\Database\Eloquent\Builder;
use JPeters\Architect\Blueprints\Blueprint;
use Coeliac\Architect\Cards\WteRatingsCard\Card;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatReview;

class RatingsBlueprint extends Blueprint
{
    public function model(): string
    {
        return WhereToEatReview::class;
    }

    public function plans(): array
    {
        return [];
    }

    public function blueprintSite(): string
    {
        return 'Where to Eat';
    }

    public function blueprintRoute(): string
    {
        return 'place-ratings';
    }

    public function displayCount(): int
    {
        return WhereToEatReview::query()->where('approved', 0)->count();
    }

    public function blueprintName(): string
    {
        return 'Ratings';
    }

    public function card(): ?string
    {
        return Card::class;
    }

    public function getData(): Builder
    {
        return parent::getData()
            ->with(['eatery', 'eatery.county', 'eatery.town', 'eatery.country'])
            ->select('*');
    }

    public function canEdit(): bool
    {
        return false;
    }
}
