<?php

declare(strict_types=1);

namespace Coeliac\Modules\Search\Indices;

use Laravel\Scout\Builder;
use Coeliac\Base\Models\BaseModel;
use Coeliac\Modules\EatingOut\Reviews\Models\Review as ReviewModel;

class Review extends Index
{
    protected function model(): Builder
    {
        return ReviewModel::search($this->term);
    }

    protected function withRelations(): array
    {
        return array_merge(
            parent::withRelations(),
            ['eatery', 'eatery.ratings', 'eatery.town', 'eatery.county', 'eatery.country'],
        );
    }

    protected function mergeIntoResult(BaseModel $result): array
    {
        return ['title' => $result->title.', '.$result->eatery->town->town.', '.$result->eatery->county->county];
    }
}
