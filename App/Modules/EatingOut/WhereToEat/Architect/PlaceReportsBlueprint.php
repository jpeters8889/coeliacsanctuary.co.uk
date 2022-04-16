<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Architect;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatPlaceReport;
use Illuminate\Database\Eloquent\Builder;
use JPeters\Architect\Blueprints\Blueprint;
use Coeliac\Architect\Cards\PlaceReportsCard\Card;

class PlaceReportsBlueprint extends Blueprint
{
    public function getData(): Builder
    {
        return $this->model()::query()->with(['eatery', 'eatery.town', 'eatery.county']);
    }

    public function canEdit(): bool
    {
        return false;
    }

    public function model(): string
    {
        return WhereToEatPlaceReport::class;
    }

    public function blueprintRoute(): string
    {
        return 'place-reports';
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
        return 'Reports';
    }

    public function displayCount(): int
    {
        return WhereToEatPlaceReport::query()->where('completed', 0)->count();
    }
}
