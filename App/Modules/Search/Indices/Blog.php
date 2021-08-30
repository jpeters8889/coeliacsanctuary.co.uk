<?php

declare(strict_types=1);

namespace Coeliac\Modules\Search\Indices;

use Algolia\ScoutExtended\Builder;
use Coeliac\Modules\Blog\Models\Blog as BlogModel;

class Blog extends Index
{
    protected function model(): Builder|\Laravel\Scout\Builder
    {
        return BlogModel::search($this->term);
    }
}
