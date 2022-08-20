<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Architect;

use Coeliac\Architect\Cards\PlaceRecommendationsCard\Card;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatRecommendation;
use Illuminate\Database\Eloquent\Builder;
use JPeters\Architect\Blueprints\Blueprint;

class PlaceRecommendationsBlueprint extends Blueprint
{
    public function model(): string
    {
        return WhereToEatRecommendation::class;
    }

    public function getData(): Builder
    {
        return parent::getData()->with('venueType')->where('email', '!=', 'alisondwheatley@gmail.com');
    }

    public function blueprintRoute(): string
    {
        return 'place-recommendations';
    }

    public function canEdit(): bool
    {
        return false;
    }

    public function plans(): array
    {
        return [];
    }

    public function blueprintSite(): string
    {
        return 'Where to Eat';
    }

    public function card(): ?string
    {
        return Card::class;
    }

    public function blueprintName(): string
    {
        return 'Recommendations';
    }

    public function displayCount(): int
    {
        return WhereToEatRecommendation::query()->where('completed', 0)
            ->where('email', '!=', 'alisondwheatley@gmail.com')
            ->count();
    }
}
