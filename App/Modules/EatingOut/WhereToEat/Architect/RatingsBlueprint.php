<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Architect;

use Illuminate\Database\Eloquent\Builder;
use JPeters\Architect\Blueprints\Blueprint;
use Coeliac\Architect\Cards\WteRatingsCard\Card;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatRating;

class RatingsBlueprint extends Blueprint
{
    public function model(): string
    {
        return WhereToEatRating::class;
    }

    public function plans(): array
    {
        return [];
    }

    public function blueprintSite(): string
    {
        return 'Approvals';
    }

    public function displayCount(): int
    {
        return WhereToEatRating::query()->where('approved', 0)->count();
    }

    public function blueprintName(): string
    {
        return 'WTE Ratings';
    }

    public function card(): ?string
    {
        return Card::class;
    }

    public function getData(): Builder
    {
        return parent::getData()->with('eatery')->select('*');
    }

    public function canEdit(): bool
    {
        return false;
    }
}
