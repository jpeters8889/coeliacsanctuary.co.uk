<?php

declare(strict_types=1);

namespace Coeliac\Common\Repositories;

use Closure;
use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

abstract class AbstractRepository
{
    protected $columns = ['*'];

    protected $withs = [];

    protected $withCounts = [];

    protected bool $isRaw = false;

    protected bool $random = false;

    abstract protected function model(): string;

    public function get($id, $column = 'id'): ?BaseModel
    {
        return $this->query()
            ->where($column, $id)
            ->first($this->getColumns());
    }

    public function count()
    {
        return $this->query()->count();
    }

    public function take($number)
    {
        return $this->query()->take($number)->get($this->getColumns());
    }

    public function all(): Collection
    {
        return $this->query()->get($this->getColumns());
    }

    public function paginated($perPage = 12, $pageName = 'page', $startPage = null): LengthAwarePaginator
    {
        return $this->query()->paginate($perPage, $this->getColumns(), $pageName, $startPage);
    }

    protected function query(): Builder
    {
        $model = $this->model();

        /** @var Builder $builder */
        $builder = $model::query();

        $builder = $this->modifyQuery(
            $builder
                ->select($this->columns)
                ->with($this->getWiths())
                ->withCount($this->getWithCounts())
        );

        /* @phpstan-ignore-next-line  */
        if (method_exists($this, 'performSearch') && $this->useSearch && $searchIds = $this->performSearch($model)) {
            $builder->whereIn('id', $searchIds)
                ->orderByRaw('field(id, '.implode(',', $searchIds).')');
        } elseif (!$this->isRaw && !$this->random) {
            $this->order($builder);
        }

        if (isset($this->filterable)) {
            $builder = $this->filterable->filter($builder);
        }

        if ($this->random) {
            $builder->inRandomOrder();
        }

        return $builder;
    }

    protected function modifyQuery(Builder $query): Builder
    {
        return $query;
    }

    protected function getColumns()
    {
        return $this->columns;
    }

    protected function getWiths()
    {
        return $this->withs;
    }

    protected function getWithCounts()
    {
        return $this->withCounts;
    }

    public function setColumns($columns = '*')
    {
        $this->columns = $columns;

        return $this;
    }

    protected function order(Builder &$builder)
    {
        //
    }

    public function raw(Closure $closure)
    {
        $this->isRaw = true;

        return $closure($this->query());
    }

    public function random()
    {
        $this->random = true;

        return $this;
    }

    public function setWiths($withs = [])
    {
        $this->withs = $withs;

        return $this;
    }

    public function setWithCounts($withCounts = [])
    {
        $this->withCounts = $withCounts;

        return $this;
    }
}
