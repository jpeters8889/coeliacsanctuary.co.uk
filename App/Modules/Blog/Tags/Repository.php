<?php

declare(strict_types=1);

namespace Coeliac\Modules\Blog\Tags;

use Coeliac\Modules\Blog\Models\BlogTag;
use Illuminate\Database\Eloquent\Builder;
use Coeliac\Common\Repositories\AbstractRepository;

class Repository extends AbstractRepository
{
    protected function model(): string
    {
        return BlogTag::class;
    }

    protected function modifyQuery(Builder $query): Builder
    {
        return $query->orderBy('blogs_count', 'desc');
    }
}
