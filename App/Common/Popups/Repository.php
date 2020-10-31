<?php

declare(strict_types=1);

namespace Coeliac\Common\Popups;

use Coeliac\Common\Models\Popup;
use Illuminate\Database\Eloquent\Builder;
use Coeliac\Common\Repositories\AbstractRepository;

class Repository extends AbstractRepository
{
    protected function model(): string
    {
        return Popup::class;
    }

    protected function order(Builder &$builder)
    {
        $builder->orderByDesc('created_at');
    }

    protected function modifyQuery(Builder $query): Builder
    {
        return parent::modifyQuery($query)->where('live', true);
    }
}
