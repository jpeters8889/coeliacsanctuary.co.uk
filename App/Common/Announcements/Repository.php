<?php

declare(strict_types=1);

namespace Coeliac\Common\Announcements;

use Carbon\Carbon;
use Coeliac\Common\Models\Announcement;
use Illuminate\Database\Eloquent\Builder;
use Coeliac\Common\Repositories\AbstractRepository;

class Repository extends AbstractRepository
{
    protected function model(): string
    {
        return Announcement::class;
    }

    protected function order(Builder &$builder)
    {
        $builder->orderBy('expires_at')->orderByDesc('created_at');
    }

    protected function modifyQuery(Builder $query): Builder
    {
        return parent::modifyQuery($query)
            ->where('live', true)
            ->whereDate('expires_at', '>', Carbon::now());
    }
}
