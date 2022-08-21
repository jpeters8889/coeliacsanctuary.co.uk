<?php

declare(strict_types=1);

namespace Coeliac\Common\Popups;

use Coeliac\Base\Models\BaseModel;
use Coeliac\Common\Models\Popup;
use Coeliac\Common\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\Builder;

/** @extends AbstractRepository<Popup> */
class Repository extends AbstractRepository
{
    /** @return class-string<BaseModel<Popup>> */
    protected function model(): string
    {
        return Popup::class;
    }

    protected function order(Builder $builder): void
    {
        $builder->orderByDesc('created_at');
    }

    protected function modifyQuery(Builder $query): Builder
    {
        return parent::modifyQuery($query)->where('live', true);
    }
}
