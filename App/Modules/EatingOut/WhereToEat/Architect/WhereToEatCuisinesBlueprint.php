<?php

namespace Coeliac\Modules\EatingOut\WhereToEat\Architect;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCuisine;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatVenueType;
use Illuminate\Database\Eloquent\Builder;
use JPeters\Architect\Blueprints\Blueprint;
use JPeters\Architect\Plans\Label;
use JPeters\Architect\Plans\Select;
use JPeters\Architect\Plans\Textfield;

class WhereToEatCuisinesBlueprint extends Blueprint
{
    public function model(): string
    {
        return WhereToEatCuisine::class;
    }

    public function plans(): array
    {
        return [
            Textfield::generate('cuisine'),

            Label::generate('eateries_count')
                ->isFromDatabase()
                ->hideOnForms(),
        ];
    }

    public function makeVisible(): array
    {
        return ['eateries_count'];
    }

    public function blueprintSite(): string
    {
        return 'Where to Eat';
    }

    public function blueprintName(): string
    {
        return 'Cuisines';
    }

    public function blueprintRoute(): string
    {
        return 'place-cuisines';
    }

    public function ordering(): array
    {
        return ['cuisine'];
    }

    public function getData(): Builder
    {
        return parent::getData()->withCount(['eateries']);
    }
}
