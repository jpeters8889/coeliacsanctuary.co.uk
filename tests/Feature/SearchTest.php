<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Str;
use Coeliac\Modules\Search\Models\SearchHistory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    protected function makeRequest($term, $areas = [])
    {
        $areas = array_merge([
            'blogs' => true,
            'reviews' => true,
            'recipes' => true,
            'eateries' => true,
            'products' => true,
        ], $areas);

        return $this->post('/api/search', [
            'search' => $term,
            'areas' => $areas,
        ]);
    }

    /** @test */
    public function it_rejects_searches_without_a_term()
    {
        return $this->makeRequest(null)->assertStatus(422);
    }

    /** @test */
    public function it_errors_with_a_search_that_is_too_long()
    {
        $this->makeRequest(Str::random(51))->assertStatus(422);
    }

    /** @test */
    public function it_returns_success_with_a_valid_search()
    {
        $this->makeRequest('foo')->assertStatus(200);
    }

    /** @test */
    public function it_logs_the_search_history()
    {
        $this->assertEmpty(SearchHistory::query()->get());

        $this->makeRequest('foo');

        $this->assertNotEmpty(SearchHistory::query()->get());

        $search = SearchHistory::query()->first();

        $this->assertEquals('foo', $search->term);
    }

    /** @test */
    public function it_stores_the_search_areas()
    {
        $this->makeRequest('first');

        $history = SearchHistory::query()->latest()->first();

        $this->assertTrue($history->blogs);
        $this->assertTrue($history->recipes);
        $this->assertTrue($history->reviews);
        $this->assertTrue($history->eateries);
        $this->assertTrue($history->products);

        $this->makeRequest('second', ['blogs' => false]);

        $history = SearchHistory::query()->orderByDesc('id')->first();

        $this->assertFalse($history->blogs);

        $this->makeRequest('third', ['products' => false]);

        $history = SearchHistory::query()->orderByDesc('id')->first();

        $this->assertFalse($history->products);
    }
}
