<?php

namespace Tests\Feature;

use Coeliac\Modules\Blog\Models\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;
use Tests\Traits\CreatesBlogs;

class SearchApiTest extends TestCase
{
    use CreatesBlogs;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpScout();
    }

    protected function makeRequest($term, $params = [])
    {
        return $this->post('/api/search', [
                'term' => $term,
                'areas' => array_merge([
                    'blogs' => true,
                    'eateries' => false,
                    'recipes' => false,
                    'reviews' => false,
                    'products' => false,
                ], $params)]
        );
    }

    /** @test */
    public function it_errors_without_a_search_term()
    {
        $this->makeRequest(null)->assertStatus(422);
    }

    /** @test */
    public function it_errors_with_a_search_term_that_is_too_big()
    {
        $this->makeRequest(Str::random(51))->assertStatus(422);
    }

    /** @test */
    public function it_returns_ok()
    {
        $this->makeRequest('foo')->assertOk();
    }

    /** @test */
    public function it_returns_as_paginated()
    {
        $this->makeRequest('foo')->assertJsonFragment(['current_page' => 1]);
    }

    /** @test */
    public function it_returns_an_expected_result()
    {
        $this->createBlog(['title' => 'foo bar']);

        $this->makeRequest('foo')
            ->assertJsonCount(1, 'data')
            ->assertJsonFragment(['title' => 'foo bar']);
    }

    /** @test */
    public function it_doesnt_return_the_result_if_its_not_live()
    {
        $this->createBlog(['title' => 'foo bar', 'live' => 0]);

        $this->makeRequest('foo')
            ->assertJsonCount(0, 'data');
    }

    /** @test */
    public function it_doesnt_return_a_blog_if_we_dont_search_for_a_blog()
    {
        $this->createBlog(['title' => 'foo bar']);

        $this->makeRequest('foo', ['blogs' => false])
            ->assertJsonCount(0, 'data');
    }
}
