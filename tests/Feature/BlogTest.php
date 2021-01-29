<?php

declare(strict_types=1);

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use Tests\Traits\HasImages;
use Tests\Traits\CreatesBlogs;
use Coeliac\Common\Models\Image;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BlogTest extends TestCase
{
    use CreatesBlogs;
    use HasImages;
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function it_loads_the_blog_index_page()
    {
        $this->get('/blog')
            ->assertStatus(200)
            ->assertSee('<module-list-index module="blogs" title="Blogs" url-prefix="blog">', false);
    }

    /** @test */
    public function it_loads_the_blog_api_endpoint()
    {
        for ($blog = 0; $blog < 13; ++$blog) {
            $this->createBlog([
                'title' => 'blog-'.$blog,
                'created_at' => Carbon::now()->subDays($blog),
            ])
                ->associateImage($this->makeImage(['file_name' => 'image-'.$blog]), Image::IMAGE_CATEGORY_HEADER)
                ->tags()->attach($this->createBlogTag(['tag' => 'tag-'.$blog]));
        }

        $request = $this->get('/api/blogs');

        $request->assertJsonStructure([
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
        ]);

        for ($blog = 0; $blog < 12; ++$blog) {
            $request->assertSee('blog-'.$blog, false);
            $request->assertSee('image-'.$blog, false);
            $request->assertSee('tag-'.$blog, false);
        }

        $request->assertDontSee('blog-12');
        $request->assertDontSee('image-12');
        $request->assertDontSee('tag-12');
    }

    /** @test */
    public function it_only_shows_matching_blogs_when_filtered_by_tags()
    {
        $visibleBlog = $this->createBlog(['title' => 'visible-blog-title']);
        $hiddenBlog = $this->createBlog(['title' => 'hidden-blog-title']);

        $visibleBlog->tags()->attach($this->createBlogTag(['slug' => 'visible']));
        $hiddenBlog->tags()->attach($this->createBlogTag(['slug' => 'hidden']));

        $this->get('/api/blogs?filter[tags]=visible')
            ->assertSee('visible-blog-title', false)
            ->assertDontSee('hidden-blog-title');
    }

    /** @test */
    public function it_only_shows_matching_blogs_when_filtered_by_years()
    {
        $this->createBlog(['title' => 'visible-blog-title']);
        $this->createBlog(['title' => 'hidden-blog-title', 'created_at' => Carbon::now()->subYear()]);

        $this->get('/api/blogs?filter[year]='.date('Y'))
            ->assertSee('visible-blog-title', false)
            ->assertDontSee('hidden-blog-title');
    }

    /** @test */
    public function it_shows_and_filters_the_blog_years_page()
    {
        $first = $this->createBlog(['title' => 'this-year-blog-one']);
        $second = $this->createBlog(['title' => 'this-year-blog-two']);
        $third = $this->createBlog(['title' => 'last-year-blog', 'created_at' => Carbon::now()->subYear()]);

        $first->tags()->attach($tag = $this->createBlogTag(['slug' => 'tag']));
        $third->tags()->attach($tag);

        $this->get('/api/blogs/years')
            ->assertStatus(200)
            ->assertJsonFragment(['year' => (int) date('Y'), 'blogs_count' => 2])
            ->assertJsonFragment(['year' => (int) date('Y') - 1, 'blogs_count' => 1]);

        $this->get('/api/blogs/years?filter[tags]=tag')
            ->assertStatus(200)
            ->assertJsonFragment(['year' => (int) date('Y'), 'blogs_count' => 1])
            ->assertJsonFragment(['year' => (int) date('Y') - 1, 'blogs_count' => 1]);
    }

    /** @test */
    public function it_shows_and_filters_the_blog_tags_page()
    {
        $first = $this->createBlog(['title' => 'this-year-blog-one']);
        $second = $this->createBlog(['title' => 'this-year-blog-two']);
        $third = $this->createBlog(['title' => 'last-year-blog', 'created_at' => Carbon::now()->subYear()]);

        $first->tags()->attach($tag = $this->createBlogTag(['tag' => 'Tag', 'slug' => 'tag']));
        $third->tags()->attach($tag);

        $second->tags()->attach($tag2 = $this->createBlogTag(['tag' => 'Tag 2', 'slug' => 'tag2']));

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

        $year = (int) date('Y') - 1;

        $this->get('/api/blogs/tags?filter[year]='.$year)
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
    public function it_shows_blog_content()
    {
        $this->withoutExceptionHandling();

        $blog = $this->createBlog();

        $blog->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_HEADER)
            ->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_SOCIAL)
            ->tags()->attach($tag = $this->createBlogTag());

        $this->get('/blog/'.$blog->slug)
            ->assertStatus(200)
            ->assertSee($blog->title, false)
            ->assertSee($blog->body, false)
            ->assertSee($blog->main_image, false)
            ->assertSee($blog->social_image, false)
            ->assertSee($tag->tag, false);
    }

    /** @test */
    public function it_doesnt_load_blogs_that_arent_live()
    {
        $this->withExceptionHandling();
        $blog = $this->createBlog(['live' => false]);

        $response = $this->get('/blog/'.$blog->slug);

        $response->assertNotFound();
    }
}
