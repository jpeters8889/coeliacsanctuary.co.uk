<?php

declare(strict_types=1);

namespace Coeliac\Common\Repositories;

use Closure;
use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Laravel\Scout\Searchable;

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

    abstract protected function model(): string;

    public function get(mixed $id, string $column = 'id'): ?BaseModel
    {
        return $this->query()
            ->where($column, $id)
            ->first($this->getColumns());
    }

    public function fromIds(array $ids, $column = 'id')
    {
        return $this->query()
            ->whereIn($column, $ids)
            ->get($this->getColumns());
    }

    public function count(): ?int
    {
        return $this->query()->count();
    }

    public function take(int $number): Collection
    {
        return $this->query()->take($number)->get($this->getColumns());
    }

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
        if (!method_exists($this, 'performSearch')) {
            return false;
        }

        if (!property_exists($this, 'useSearch')) {
            return false;
        }

        return true;
    }

    protected function performSearch(string $model): array|null
    {
        return null;
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

        if ($this->shouldSearch() && $searchIds = $this->performSearch($model)) {
            $builder->whereIn('id', $searchIds)
                ->orderByRaw('field(id, ' . implode(',', $searchIds) . ')');
        } elseif (!$this->isRaw && !$this->random) {
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

        foreach ($this->havings as $having) {
            $builder->having(...$having);
        }

        return $builder;
    }

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
}
