<?php

declare(strict_types=1);

namespace Coeliac\Modules\Search\Service;

use Coeliac\Modules\Search\Indices\Blog;
use Coeliac\Modules\Search\Indices\Eatery;
use Coeliac\Modules\Search\Indices\Index;
use Coeliac\Modules\Search\Indices\Product;
use Coeliac\Modules\Search\Indices\Recipe;
use Illuminate\Support\Collection;

class IndexManager
{
    protected Search $searchService;
    protected array $indices = [];

    public function __construct(Search $searchService)
    {
        $this->searchService = $searchService;

        $this->bootIndices();
    }

    protected function bootIndices(): void
    {
        $this->indices = [
            'blogs' => Blog::class,
            'recipes' => Recipe::class,
            'eateries' => Eatery::class,
            'products' => Product::class,
        ];
    }

    public function search(): Collection
    {
        $resultSet = new Collection();

        foreach ($this->indices as $key => $index) {
            if (! $this->searchService->isSearchable((string) $key)) {
                continue;
            }

            $resultSet->push(...$this->runSearchOnIndex($index));
        }

        return $this->sortResults($resultSet);
    }

    protected function sortResults(Collection $results): Collection
    {
        return $results->sortBy(fn (array $result) => [
            $result['word'],
            -$result['score'],
        ])->values();
    }

    protected function runSearchOnIndex(string $index): Collection
    {
        /** @var Index $concreteIndex */
        $concreteIndex = new $index($this->searchService->searchTerm());

        return $concreteIndex->handle();
    }
}
