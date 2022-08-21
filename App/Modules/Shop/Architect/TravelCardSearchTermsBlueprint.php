<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Architect;

use Coeliac\Architect\Plans\ShopTravelCardSearchTerms\Plan;
use Coeliac\Modules\Shop\Models\TravelCardSearchTerm;
use Illuminate\Database\Eloquent\Builder;
use JPeters\Architect\Blueprints\Blueprint;
use JPeters\Architect\Plans\Select;
use JPeters\Architect\Plans\Textfield;

class TravelCardSearchTermsBlueprint extends Blueprint
{
    public function blueprintSite(): string
    {
        return 'Search';
    }

    public function getData(): Builder
    {
        return parent::getData()->withCount('products');
    }

    public function blueprintName(): string
    {
        return 'Travel Card Search Terms';
    }

    public function blueprintRoute(): string
    {
        return 'travel-card-search-terms';
    }

    public function model(): string
    {
        return TravelCardSearchTerm::class;
    }

    public function plans(): array
    {
        return [
            Textfield::generate('term'),

            Select::generate('type')->options(['country' => 'Country', 'language' => 'Language']),

            Textfield::generate('hits', 'Clicks')->hideOnForms(),

            Plan::generate('products_count')->hideOnForms(),

            Plan::generate('products')->isInRelationship('products')->hideOnIndex(),
        ];
    }
}
