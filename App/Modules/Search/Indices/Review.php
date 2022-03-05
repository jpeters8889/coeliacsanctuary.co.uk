<?php

declare(strict_types=1);

namespace Coeliac\Modules\Search\Indices;

use Algolia\ScoutExtended\Builder;
use Coeliac\Base\Models\BaseModel;
use Coeliac\Modules\EatingOut\Reviews\Models\Review as ReviewModel;

/** @deprecated  */
class Review extends Index
{
    protected function model(): Builder|\Laravel\Scout\Builder
    {
        return ReviewModel::search($this->term);
    }

    protected function withRelations(): array
    {
        return array_merge(
            parent::withRelations(),
            ['eatery', 'eatery.userReviews', 'eatery.town', 'eatery.county', 'eatery.country'],
        );
    }

    protected function mergeIntoResult(BaseModel $result): array
    {
        /** @var ReviewModel $result */

        return ['title' => $result->title.', '.$result->eatery->town->town.', '.$result->eatery->county->county];
    }
}
