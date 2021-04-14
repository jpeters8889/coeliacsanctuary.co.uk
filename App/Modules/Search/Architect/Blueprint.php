<?php

declare(strict_types=1);

namespace Coeliac\Modules\Search\Architect;

use JPeters\Architect\Plans\DateTime;
use JPeters\Architect\Plans\Textfield;
use Coeliac\Modules\Search\Models\SearchHistory;
use JPeters\Architect\Blueprints\Blueprint as Architect;

class Blueprint extends Architect
{
    public function blueprintSite(): string
    {
        return 'Logs';
    }

    public function model(): string
    {
        return SearchHistory::class;
    }

    public function blueprintName(): string
    {
        return 'Search History';
    }

    public function blueprintRoute(): string
    {
        return 'search-history';
    }

    public function canEdit(): bool
    {
        return false;
    }

    public function ordering(): array
    {
        return ['number_of_searches', 'desc'];
    }

    public function plans(): array
    {
        return [
            Textfield::generate('term'),

            Textfield::generate('number_of_searches'),

            DateTime::generate('created_at', 'First Search'),

            DateTime::generate('updated_at', 'Most Recent Search'),
        ];
    }
}
