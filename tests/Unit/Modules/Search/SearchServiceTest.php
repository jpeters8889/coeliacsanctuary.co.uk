<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Search;

use Tests\TestCase;
use Coeliac\Modules\Search\Service\Search;
use Coeliac\Modules\Search\Exceptions\SearchException;

class SearchServiceTest extends TestCase
{
    protected Search $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new Search();
    }

    /** @test */
    public function itErrorsIfTheSearchIndexDoesntExist()
    {
        $this->expectException(SearchException::class);

        $this->service->shouldSearch('foo');
    }

    /**
     * @test
     * @dataProvider indexDataProvider
     */
    public function itSetsWhetherTheIndicesAreSearchable($index, $default)
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
    public function itCanHaveTheSearchTermSet()
    {
        $this->service->searchFor('foo');

        $this->assertEquals('foo', $this->service->searchTerm());
    }
}
