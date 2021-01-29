<?php

namespace Tests\Unit;

use Coeliac\Modules\Search\Exceptions\SearchException;
use Coeliac\Modules\Search\Service\Search;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Tests\TestCase;

class SearchServiceTest extends TestCase
{
    protected Search $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new Search();
    }

    /** @test */
    public function it_errors_if_the_search_index_doesnt_exist()
    {
        $this->expectException(SearchException::class);

        $this->service->shouldSearch('foo');
    }

    /**
     * @test
     * @dataProvider indexDataProvider
     */
    public function it_sets_whether_the_indices_are_searchable($index, $default)
    {
        $method = 'shouldSearch'.ucfirst($index);

        $this->assertSame($default, $this->service->isSearchable($index));

        $this->service->$method(!$default);

        $this->assertSame(!$default, $this->service->isSearchable($index));
    }

    public function indexDataProvider()
    {
        return [
          ['blogs', true],
          ['recipes', true],
          ['reviews', true],
          ['eateries', false],
          ['products', true],
        ];
    }

    /** @test */
    public function it_can_have_the_search_term_set()
    {
        $this->service->searchFor('foo');

        $this->assertEquals('foo', $this->service->searchTerm());
    }
}
