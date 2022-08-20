<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Architect;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatVenueType;
use JPeters\Architect\Blueprints\Blueprint;
use JPeters\Architect\Plans\Select;
use JPeters\Architect\Plans\Textfield;

class WhereToEatVenueTypesBlueprint extends Blueprint
{
    public function model(): string
    {
        return WhereToEatVenueType::class;
    }

    public function plans(): array
    {
        return [
            Textfield::generate('venue_type'),

            Select::generate('type_id')
                ->hideOnIndex()
                ->options([
                    '1' => 'Eateries',
                    '2' => 'Attractions',
                ]),
        ];
    }

    public function blueprintSite(): string
    {
        return 'Where to Eat';
    }

    public function blueprintName(): string
    {
        return 'Venue Types';
    }

    public function blueprintRoute(): string
    {
        return 'place-venue-types';
    }

    public function ordering(): array
    {
        return ['venue_type'];
    }
}
