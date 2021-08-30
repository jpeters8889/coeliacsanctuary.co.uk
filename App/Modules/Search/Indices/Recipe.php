<?php

declare(strict_types=1);

namespace Coeliac\Modules\Search\Indices;

use Algolia\ScoutExtended\Builder;
use Coeliac\Modules\Recipe\Models\Recipe as RecipeModel;

class Recipe extends Index
{
    protected function model(): Builder|\Laravel\Scout\Builder
    {
        return RecipeModel::search($this->term);
    }
}
