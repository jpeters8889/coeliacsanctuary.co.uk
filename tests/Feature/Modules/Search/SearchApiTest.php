<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Search;

use Coeliac\Modules\Blog\Models\Blog;
use Illuminate\Support\Str;
use Tests\TestCase;

class SearchApiTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpScout();
    }

    protected function makeRequest($term, $params = [])
    {
        return $this->post(
            '/api/search',
            [
                'term' => $term,
                'areas' => array_merge([
                    'blogs' => true,
                    'eateries' => false,
                    'recipes' => false,
                    'reviews' => false,
                    'products' => false,
                ], $params), ]
        );
    }

    /** @test */
    public function itErrorsWithoutASearchTerm()
    {
        $this->makeRequest(null)->assertStatus(422);
    }

    /** @test */
    public function itErrorsWithASearchTermThatIsTooBig()
    {
        $this->makeRequest(Str::random(51))->assertStatus(422);
    }

    /** @test */
    public function itReturnsOk()
    {
        $this->makeRequest('foo')->assertOk();
    }

    /** @test */
    public function itReturnsAsPaginated()
    {
        $this->makeRequest('foo')->assertJsonFragment(['current_page' => 1]);
    }

    /** @test */
    public function itReturnsAnExpectedResult()
    {
        $this->create(Blog::class, ['title' => 'foo bar']);

        $this->makeRequest('foo')
            ->assertJsonCount(1, 'data')
            ->assertJsonFragment(['title' => 'foo bar']);
    }

    /** @test */
    public function itDoesntReturnTheResultIfItsNotLive()
    {
        $this->build(Blog::class)
            ->notLive()
            ->state(['title' => 'foo bar'])
            ->create();

        $this->makeRequest('foo')
            ->assertJsonCount(0, 'data');
    }

    /** @test */
    public function itDoesntReturnABlogIfWeDontSearchForABlog()
    {
        $this->create(Blog::class, ['title' => 'foo bar']);

        $this->makeRequest('foo', ['blogs' => false])
            ->assertJsonCount(0, 'data');
    }
}
