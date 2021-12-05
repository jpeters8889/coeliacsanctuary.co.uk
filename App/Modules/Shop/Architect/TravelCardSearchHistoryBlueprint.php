<?php

namespace Coeliac\Modules\Shop\Architect;

use Coeliac\Modules\Shop\Models\TravelCardSearchTermHistory;
use JPeters\Architect\Blueprints\Blueprint;
use JPeters\Architect\Plans\DateTime;
use JPeters\Architect\Plans\Textfield;

class TravelCardSearchHistoryBlueprint extends Blueprint
{
    public function blueprintSite(): string
    {
        return 'Search';
    }

    public function blueprintName(): string
    {
        return 'Travel Card Search History';
    }

    public function blueprintRoute(): string
    {
        return 'travel-card-search-history';
    }

    public function model(): string
    {
        return TravelCardSearchTermHistory::class;
    }

    public function plans(): array
    {
        return [
            Textfield::generate('term'),

            Textfield::generate('hits', 'Searches'),

            DateTime::generate('updated_at', 'Most Recent'),
        ];
    }

    public function canEdit(): bool
    {
        return false;
    }
}
