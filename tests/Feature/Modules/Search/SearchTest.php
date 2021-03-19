<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Search;

use Tests\TestCase;
use Coeliac\Modules\Search\Models\SearchHistory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function itReturnsSuccessWithAValidSearchString()
    {
        $this->get('/search?q=foo')->assertStatus(200);
    }

    /** @test */
    public function itCreatesARecordInTheSearchHistory()
    {
        $this->assertEmpty(SearchHistory::query()->get());

        $this->get('/search?q=foo');

        $this->assertNotEmpty(SearchHistory::query()->get());

        $search = SearchHistory::query()->first();

        $this->assertEquals('foo', $search->term);
    }

    /** @test */
    public function itDoesntDuplicateSearchHistory()
    {
        $this->get('/search?q=foo');

        $this->assertCount(1, SearchHistory::all());

        $this->get('/search?q=foo');

        $this->assertCount(1, SearchHistory::all());
    }

    /** @test */
    public function itUpdatesTheSearchCount()
    {
        $this->get('/search?q=foo');

        /** @var SearchHistory $history */
        $history = SearchHistory::query()->first();

        $this->assertEquals(1, $history->number_of_searches);

        $this->get('/search?q=foo');

        $this->assertEquals(2, $history->fresh()->number_of_searches);
    }
}
