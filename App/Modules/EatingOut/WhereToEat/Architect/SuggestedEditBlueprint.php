<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Architect;

use Coeliac\Architect\Cards\WteSuggestedEdits\Card;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatSuggestedEdit;
use Illuminate\Database\Eloquent\Builder;
use JPeters\Architect\Blueprints\Blueprint;

class SuggestedEditBlueprint extends Blueprint
{
    public function model(): string
    {
        return WhereToEatSuggestedEdit::class;
    }

    public function plans(): array
    {
        return [];
    }

    public function canEdit(): bool
    {
        return false;
    }

    public function card(): ?string
    {
        return Card::class;
    }

    public function blueprintSite(): string
    {
        return 'Where to Eat';
    }

    public function blueprintName(): string
    {
        return 'Suggested Edits';
    }

    public function blueprintRoute(): string
    {
        return 'place-suggested-edits';
    }

    public function getData(): Builder
    {
        return parent::getData()
            ->join('wheretoeat', 'wheretoeat_suggested_edits.wheretoeat_id', '=', 'wheretoeat.id')
            ->join('wheretoeat_countries', 'wheretoeat.country_id', '=', 'wheretoeat_countries.id')
            ->join('wheretoeat_counties', 'wheretoeat.county_id', '=', 'wheretoeat_counties.id')
            ->join('wheretoeat_towns', 'wheretoeat.town_id', '=', 'wheretoeat_towns.id')
            ->addSelect([
                'wheretoeat_suggested_edits.*', 'wheretoeat.town_id', 'wheretoeat.county_id', 'wheretoeat.country_id',
            ])
            ->selectRaw('concat(wheretoeat.name, ", ", town, ", ", country, ", ", country) eatery');
    }

    public function displayCount(): int
    {
        return WhereToEatSuggestedEdit::query()
            ->where('rejected', 0)
            ->where('accepted', 0)
            ->count();
    }
}
