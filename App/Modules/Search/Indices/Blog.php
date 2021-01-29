<?php

declare(strict_types=1);

namespace Coeliac\Modules\Search\Indices;

use Laravel\Scout\Builder;
use Coeliac\Modules\Blog\Models\Blog as BlogModel;

class Blog extends Index
{
    protected function model(): Builder
    {
        return BlogModel::search($this->term);
    }
}
