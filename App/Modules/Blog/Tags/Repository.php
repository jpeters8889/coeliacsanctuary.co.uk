<?php

declare(strict_types=1);

namespace Coeliac\Modules\Blog\Tags;

use Coeliac\Base\Models\BaseModel;
use Coeliac\Common\Repositories\AbstractRepository;
use Coeliac\Modules\Blog\Models\BlogTag;
use Illuminate\Database\Eloquent\Builder;

/** @extends AbstractRepository<BlogTag> */
class Repository extends AbstractRepository
{
    /** @return class-string<BaseModel<BlogTag>> */
    protected function model(): string
    {
        return BlogTag::class;
    }

    /**
     * @param Builder<BlogTag> $query
     * @return Builder<BlogTag>
     */
    protected function modifyQuery(Builder $query): Builder
    {
        return $query->orderBy('blogs_count', 'desc');
    }
}
