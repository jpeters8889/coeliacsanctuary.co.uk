<?php

declare(strict_types=1);

namespace Coeliac\Modules\Blog;

use Coeliac\Base\Models\BaseModel;
use Coeliac\Common\Notifications\DisplayedInNotifications;
use Coeliac\Common\Repositories\AbstractRepository;
use Coeliac\Common\Traits\Filterable;
use Coeliac\Common\Traits\Searchable;
use Coeliac\Modules\Blog\Models\Blog;
use Illuminate\Database\Eloquent\Builder;

/** @extends AbstractRepository<Blog> */
class Repository extends AbstractRepository
{
    use Filterable;
    use Searchable;
    use DisplayedInNotifications;

    protected array $withs = ['images', 'images.image', 'tags'];

    /** @return class-string<BaseModel<Blog>> */
    protected function model(): string
    {
        return Blog::class;
    }

    protected function order(Builder $builder): void
    {
        $builder->latest();
    }

    protected function modifyQuery(Builder $query): Builder
    {
        return parent::modifyQuery($query)->where('live', true);
    }
}
