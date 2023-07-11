<?php

declare(strict_types=1);

namespace Coeliac\Common\Repositories;

use Closure;
use Coeliac\Base\Models\BaseModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder as QueryBuilder;

/**
 * @template TModel of \Coeliac\Base\Models\BaseModel
 * @phpstan-consistent-constructor
 */
abstract class AbstractRepository
{
    protected array $columns = ['*'];

    protected array $withs = [];

    protected array $withCounts = [];

    protected bool $isRaw = false;

    protected bool $random = false;

    protected array $rawSelects = [];

    protected array $havings = [];

    protected array $wheres = [];
    protected array $whens = [];

    /** @return class-string<TModel> */
    abstract protected function model(): string;

    /** @return TModel | null */
    public function get(mixed $id, string $column = 'id')
    {
        return $this->query()
            ->where($column, $id)
            ->first($this->getColumns());
    }

    /** @return TModel | null */
    public function getOrFail(mixed $id, string $column = 'id')
    {
        return $this->query()
            ->where($column, $id)
            ->firstOrFail($this->getColumns());
    }

    /** @return TModel */
    public function firstOrFail()
    {
        return $this->query()->firstOrFail();
    }

    /** @return Collection<int, TModel | TModel | BaseModel> */
    public function fromIds(array $ids, $column = 'id'): Collection
    {
        return $this->query()
            ->whereIn($column, $ids)
            ->get($this->getColumns());
    }

    public function count(): ?int
    {
        return $this->query()->count();
    }

    /** @return Collection<int, TModel> */
    public function take(int $number): Collection
    {
        /** @var Collection<int, TModel> $foo */
        $foo = $this->query()->take($number)->get($this->getColumns());

        return $foo;
    }

    /** @return Collection<int, TModel> */
    public function all(): Collection
    {
        return $this->query()->get($this->getColumns());
    }

    public function paginated(int $perPage = 12, string $pageName = 'page', ?int $startPage = null): LengthAwarePaginator
    {
        return $this->query()->paginate($perPage, $this->getColumns(), $pageName, $startPage);
    }

    public function selectRaw(string $query, array $bindings = []): static
    {
        $this->rawSelects[] = [$query, $bindings];

        return $this;
    }

    public function having(mixed ...$params): static
    {
        $this->havings[] = $params;

        return $this;
    }

    public function where(mixed ...$params): static
    {
        $this->wheres[] = $params;

        return $this;
    }

    protected function shouldSearch(): bool
    {
        if (! method_exists($this, 'performSearch')) {
            return false;
        }

        if (! property_exists($this, 'useSearch')) {
            return false;
        }

        return true;
    }

    protected function performSearch(string $model): array|null
    {
        return null;
    }

    /** @return Builder<TModel> */
    protected function query(): Builder
    {
        /** @var class-string<TModel> $model */
        $model = $this->model();

        /** @var Builder<TModel> $baseQuery */
        $baseQuery = $model::query()
            ->select($this->columns)
            ->with($this->getWiths())
            ->withCount($this->getWithCounts());

        /** @var Builder<TModel> $builder */
        $builder = $this->modifyQuery($baseQuery);

        if ($this->shouldSearch() && $searchIds = $this->performSearch($model)) {
            $table = app($model)->getTable();

            $key = "{$table}.id";

            $order = 'field('.$key.', ' . implode(',', $searchIds) . ')';

            if (app()->runningUnitTests()) {
                $order = $key;
            }

            $builder->whereIn($key, $searchIds)->orderByRaw($order);
        } elseif (! $this->isRaw && ! $this->random) {
            $this->order($builder);
        }

        if (isset($this->filterable)) {
            $builder = $this->filterable->filter($builder);
        }

        if ($this->random) {
            $builder->inRandomOrder();
        }

        foreach ($this->rawSelects as $rawSelect) {
            $builder->selectRaw($rawSelect[0], $rawSelect[1]);
        }

        foreach ($this->wheres as $where) {
            $builder->where(...$where);
        }

        foreach ($this->whens as $when) {
            $builder->when($when[0], $when[1]);
        }

        foreach ($this->havings as $having) {
            $builder->having(...$having);
        }

        return $builder;
    }

    /**
     * @param Builder<TModel> $query
     * @return Builder<TModel>
     */
    protected function modifyQuery(Builder $query): Builder
    {
        return $query;
    }

    protected function getColumns(): array
    {
        return $this->columns;
    }

    protected function getWiths(): array
    {
        return $this->withs;
    }

    protected function getWithCounts(): array
    {
        return $this->withCounts;
    }

    public function setColumns(array $columns = ['*']): static
    {
        $this->columns = $columns;

        return $this;
    }

    protected function order(Builder $builder): void
    {
        //
    }

    public function raw(Closure $closure): mixed
    {
        $this->isRaw = true;

        return $closure($this->query());
    }

    public function random(): static
    {
        $this->random = true;

        return $this;
    }

    public function setWiths(array $withs = []): static
    {
        $this->withs = $withs;

        return $this;
    }

    public function setWithCounts(array $withCounts = []): static
    {
        $this->withCounts = $withCounts;

        return $this;
    }

    public function when(bool $condition, Closure $action): static
    {
        $this->whens[] = [$condition, $action];

        return $this;
    }

    public function toBase(): QueryBuilder
    {
        return $this->query()->toBase();
    }
}
