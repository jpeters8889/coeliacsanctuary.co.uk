<?php

declare(strict_types=1);

namespace Coeliac\Modules\Search\Service;

use Coeliac\Modules\Search\Exceptions\SearchException;
use Illuminate\Support\Collection;

class Search
{
    protected string $term = '';

    protected array $indices = [
        'blogs' => '',
        'recipes' => '',
        'eateries' => '',
        'products' => '',
    ];

    protected array $shouldSearch = [
        'blogs' => true,
        'recipes' => true,
        'eateries' => false,
        'products' => true,
    ];

    public function searchFor(string $term): static
    {
        $this->term = $term;

        return $this;
    }

    public function shouldSearchBlogs(bool $shouldSearch): static
    {
        return $this->shouldSearch('blogs', $shouldSearch);
    }

    public function shouldSearchRecipes(bool $shouldSearch): static
    {
        return $this->shouldSearch('recipes', $shouldSearch);
    }

    public function shouldSearchEateries(bool $shouldSearch): static
    {
        return $this->shouldSearch('eateries', $shouldSearch);
    }

    public function shouldSearchProducts(bool $shouldSearch): static
    {
        return $this->shouldSearch('products', $shouldSearch);
    }

    public function shouldSearch(string $what, bool $value = true): static
    {
        $this->verifyIndex($what);

        $this->shouldSearch[$what] = $value;

        return $this;
    }

    public function isSearchable(string $what): bool
    {
        $this->verifyIndex($what);

        return $this->shouldSearch[$what];
    }

    public function handle(): Collection
    {
        $indexManager = new IndexManager($this);

        return $indexManager->search();
    }

    protected function verifyIndex(string $what): void
    {
        if (! array_key_exists($what, $this->shouldSearch)) {
            throw new SearchException("Unknown search index '{$what}'");
        }
    }

    public function searchTerm(): string
    {
        return $this->term;
    }
}
