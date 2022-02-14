<?php

declare(strict_types=1);

namespace Coeliac\Modules\Blog;

use Coeliac\Common\Notifications\DisplayedInNotifications;
use Coeliac\Common\Traits\Filterable;
use Coeliac\Common\Traits\Searchable;
use Coeliac\Modules\Blog\Models\Blog;
use Illuminate\Database\Eloquent\Builder;
use Coeliac\Common\Repositories\AbstractRepository;

class Repository extends AbstractRepository
{
    use Filterable;
    use Searchable;
    use DisplayedInNotifications;

    protected array $withs = ['images', 'images.image', 'tags'];

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
