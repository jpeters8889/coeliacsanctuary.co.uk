<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Blogs;

use Coeliac\Modules\Blog\Models\BlogTag;
use Tests\TestCase;
use Tests\Traits\HasImages;
use Coeliac\Common\Models\Image;
use Coeliac\Common\Models\Comment;
use Tests\Traits\ClearsCache;
use Coeliac\Modules\Blog\Models\Blog;

class BlogModelTest extends TestCase
{
    use ClearsCache;
    use HasImages;

    private Blog $blog;

    public function setUp(): void
    {
        parent::setUp();

        $this->blog = $this->build(Blog::class)
            ->has($this->build(BlogTag::class)->count(5), 'tags')
            ->create();

        $this->blog->associateImage($this->makeImage());
    }

    /** @test */
    public function itHasTags()
    {
        $this->assertEquals(5, $this->blog->tags()->count());
    }

    /** @test */
    public function itHasAnImage()
    {
        $this->assertEquals(1, $this->blog->images->count());
    }

    /** @test */
    public function itHasAMainImage()
    {
        $this->blog->associateImage($image = $this->makeImage(), Image::IMAGE_CATEGORY_HEADER);

        $this->assertEquals($image->image_url, $this->blog->main_image);
    }

    /** @test */
    public function itHasASocialImage()
    {
        $this->blog->associateImage($image = $this->makeImage(), Image::IMAGE_CATEGORY_SOCIAL);

        $this->assertEquals($image->image_url, $this->blog->social_image);
    }

    /** @test */
    public function itCanSaveComments()
    {
        $comment = $this->build(Comment::class)->on($this->blog)->create();

        $this->blog->comments()->save($comment);

        $this->assertEquals(1, $this->blog->allComments()->count());
    }

    protected function cacheKey(): string
    {
        return 'blogs';
    }

    protected function makeCachedModel(): void
    {
        $this->create(Blog::class);
    }
}
