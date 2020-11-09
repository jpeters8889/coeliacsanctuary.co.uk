<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;
use Tests\Traits\HasImages;
use Tests\Traits\CreatesBlogs;
use Coeliac\Common\Models\Image;
use Coeliac\Common\Models\Comment;
use Tests\Traits\ClearingCacheTest;
use Coeliac\Modules\Blog\Models\Blog;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BlogModelTest extends TestCase
{
    use ClearingCacheTest;
    use CreatesBlogs;
    use HasImages;
    use RefreshDatabase;
    use WithFaker;

    /** @var Blog */
    private $blog;

    public function setUp(): void
    {
        parent::setUp();

        $this->blog = $this->createBlog();
        $this->blog->tags()->attach($this->createBlogTag());
        $this->blog->associateImage($this->makeImage());
    }

    /** @test */
    public function it_has_a_tag()
    {
        $this->assertEquals(1, $this->blog->tags->count());
    }

    /** @test */
    public function it_has_an_image()
    {
        $this->assertEquals(1, $this->blog->images->count());
    }

    /** @test */
    public function it_has_a_main_image()
    {
        $this->blog->associateImage($image = $this->makeImage(), Image::IMAGE_CATEGORY_HEADER);

        $this->assertEquals($image->image_url, $this->blog->main_image);
    }

    /** @test */
    public function it_has_a_social_image()
    {
        $this->blog->associateImage($image = $this->makeImage(), Image::IMAGE_CATEGORY_SOCIAL);

        $this->assertEquals($image->image_url, $this->blog->social_image);
    }

    /** @test */
    public function it_can_save_comments()
    {
        $comment = factory(Comment::class)->create([
            'commentable_id' => $this->blog->id,
            'commentable_type' => Blog::class,
        ]);

        $this->blog->comments()->save($comment);

        $this->assertEquals(1, $this->blog->allComments()->count());
    }

    protected function cacheKey(): string
    {
        return 'blogs';
    }

    protected function makeCachedModel(): void
    {
        $this->createBlog();
    }
}
