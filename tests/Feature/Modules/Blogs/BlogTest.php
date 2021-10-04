<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Blogs;

use Carbon\Carbon;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\Blog\Models\BlogTag;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;
use Tests\Traits\HasImages;
use Coeliac\Common\Models\Image;
use Illuminate\Foundation\Testing\WithFaker;

class BlogTest extends TestCase
{
    use HasImages;
    use WithFaker;

    /** @test */
    public function itLoadsTheBlogIndexPage()
    {
        $this->get('/blog')
            ->assertStatus(200)
            ->assertSee('<module-list-index module="blogs" title="Blogs" url-prefix="blog"', false);
    }

    /** @test */
    public function itLoadsTheBlogApiEndpoint()
    {
        $this->build(Blog::class)
            ->count(13)
            ->sequence(fn ($sequence) => ['created_at' => Carbon::now()->subMonth()->addDay($sequence->index)])
            ->create();

        $this->get('/api/blogs')
            ->assertJsonStructure([
                'data' => [
                    'current_page',
                    'data',
                    'first_page_url',
                    'from',
                    'last_page',
                    'last_page_url',
                    'next_page_url',
                    'path',
                    'per_page',
                    'prev_page_url',
                    'to',
                    'total',
                ],
            ])
            ->assertJsonMissing(['id' => 1]);
    }

    /** @test */
    public function itOnlyShowsMatchingBlogsWhenFilteredByTags()
    {
        [$visibleBlog, $hiddenBlog] = $this->build(Blog::class)
            ->count(2)
            ->state(new Sequence(
                ['title' => 'Visible Blog'],
                ['title' => 'Hidden Blog'],
            ))
            ->create();

        [$visibleTag, $hiddenTag] = $this->build(BlogTag::class)
            ->count(2)
            ->state(new Sequence(
                ['slug' => 'visible'],
                ['slug' => 'hidden'],
            ))
            ->create();

        $visibleBlog->tags()->attach($visibleTag);
        $hiddenBlog->tags()->attach($hiddenTag);

        $this->get('/api/blogs?filter[tags]=visible')
            ->assertSee('Visible Blog', false)
            ->assertDontSee('Hidden Blog');
    }

    /** @test */
    public function itOnlyShowsMatchingBlogsWhenFilteredByYears()
    {
        $this->build(Blog::class)
            ->count(2)
            ->state(new Sequence(
                ['title' => 'Visible Blog'],
                ['title' => 'Hidden Blog', 'created_at' => Carbon::now()->subYear()],
            ))
            ->create();

        $this->get('/api/blogs?filter[year]=' . date('Y'))
            ->assertSee('Visible Blog', false)
            ->assertDontSee('Hidden Blog');
    }

    /** @test */
    public function itShowsAndFiltersTheBlogYearsPage()
    {
        [$first, , $third] = $this->build(Blog::class)
            ->count(3)
            ->state(new Sequence([], [], ['created_at' => Carbon::now()->subYear()]))
            ->create();

        $tag = $this->create(BlogTag::class, ['slug' => 'tag']);

        $first->tags()->attach($tag);
        $third->tags()->attach($tag);

        $this->get('/api/blogs/years')
            ->assertStatus(200)
            ->assertJsonFragment(['year' => (int)date('Y'), 'blogs_count' => 2])
            ->assertJsonFragment(['year' => (int)date('Y') - 1, 'blogs_count' => 1]);

        $this->get('/api/blogs/years?filter[tags]=tag')
            ->assertStatus(200)
            ->assertJsonFragment(['year' => (int)date('Y'), 'blogs_count' => 1])
            ->assertJsonFragment(['year' => (int)date('Y') - 1, 'blogs_count' => 1]);
    }

    /** @test */
    public function itShowsAndFiltersTheBlogTagsPage()
    {
        [$first, $second, $third] = $this->build(Blog::class)
            ->count(3)
            ->state(new Sequence([], [], ['created_at' => Carbon::now()->subYear()]))
            ->create();

        [$tag, $tag2] = $this->build(BlogTag::class)
            ->count(2)
            ->state(new Sequence(
                ['tag' => 'Tag', 'slug' => 'tag'],
                ['tag' => 'Tag 2', 'slug' => 'tag2'],
            ))
            ->create();

        $first->tags()->attach($tag);
        $third->tags()->attach($tag);
        $second->tags()->attach($tag2);

        $this->get('/api/blogs/tags')
            ->assertJsonFragment([
                'slug' => 'tag',
                'title' => 'Tag',
                'blogs_count' => 2,
            ])
            ->assertJsonFragment([
                'slug' => 'tag2',
                'title' => 'Tag 2',
                'blogs_count' => 1,
            ]);

        $year = (int)date('Y') - 1;

        $this->get('/api/blogs/tags?filter[year]=' . $year)
            ->assertJsonFragment([
                'slug' => 'tag',
                'title' => 'Tag',
                'blogs_count' => 1,
            ])
            ->assertJsonMissing([
                'slug' => 'tag2',
                'title' => 'Tag 2',
            ]);
    }

    /** @test */
    public function itShowsBlogContent()
    {
        $blog = $this->create(Blog::class);

        $blog->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_HEADER)
            ->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_SOCIAL)
            ->tags()->attach($tag = $this->create(BlogTag::class));

        $this->get('/blog/' . $blog->slug)
            ->assertStatus(200)
            ->assertSee($blog->title, false)
            ->assertSee($blog->body, false)
            ->assertSee($blog->main_image, false)
            ->assertSee($blog->social_image, false)
            ->assertSee($tag->tag, false);
    }

    /** @test */
    public function itDoesntLoadBlogsThatArentLive()
    {
        $blog = $this->build(Blog::class)->notLive()->create();

        $this->get('/blog/' . $blog->slug)->assertNotFound();
    }
}
