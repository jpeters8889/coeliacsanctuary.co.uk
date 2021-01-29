<?php

declare(strict_types=1);

namespace Coeliac\Modules\Search\Service;

use Illuminate\Support\Collection;
use Coeliac\Modules\Search\Exceptions\SearchException;

class Search
{
    protected string $term = '';

    protected array $indices = [
        'blogs' => '',
        'recipes' => '',
        'reviews' => '',
        'eateries' => '',
        'products' => '',
    ];

    protected array $shouldSearch = [
        'blogs' => true,
        'recipes' => true,
        'reviews' => true,
        'eateries' => false,
        'products' => true,
    ];

    public function searchFor($term): self
    {
        $this->term = $term;

        return $this;
    }

    public function shouldSearchBlogs(bool $shouldSearch): self
    {
        return $this->shouldSearch('blogs', $shouldSearch);
    }

    public function shouldSearchRecipes(bool $shouldSearch): self
    {
        return $this->shouldSearch('recipes', $shouldSearch);
    }

    public function shouldSearchReviews(bool $shouldSearch): self
    {
        return $this->shouldSearch('reviews', $shouldSearch);
    }

    public function shouldSearchEateries(bool $shouldSearch): self
    {
        return $this->shouldSearch('eateries', $shouldSearch);
    }

    public function shouldSearchProducts(bool $shouldSearch): self
    {
        return $this->shouldSearch('products', $shouldSearch);
    }

    public function shouldSearch(string $what, bool $value = true): self
    {
        $this->verifyIndex($what);

        $this->shouldSearch[$what] = $value;

        return $this;
    }

    public function isSearchable($what)
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
        if (!array_key_exists($what, $this->shouldSearch)) {
            throw new SearchException("Unknown search index '{$what}'");
        }
    }

    public function searchTerm(): string
    {
        return $this->term;
    }
}
