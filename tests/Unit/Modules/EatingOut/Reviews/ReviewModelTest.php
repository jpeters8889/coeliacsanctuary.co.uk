<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\EatingOut\Reviews;

use Coeliac\Common\Models\Comment;
use Coeliac\Common\Models\Image;
use Coeliac\Modules\EatingOut\Reviews\Models\Review;
use Tests\TestCase;
use Tests\Traits\ClearsCache;
use Tests\Traits\HasImages;

class ReviewModelTest extends TestCase
{
    use ClearsCache;
    use HasImages;

    private Review $review;

    public function setUp(): void
    {
        parent::setUp();

        $this->review = $this->create(Review::class);
        $this->review->associateImage($this->makeImage());
    }

    /** @test */
    public function itHasAnImage()
    {
        $this->assertEquals(1, $this->review->images()->count());
    }

    /** @test */
    public function itHasAMainImage()
    {
        $this->review->associateImage($image = $this->makeImage(), Image::IMAGE_CATEGORY_HEADER);

        $this->assertEquals($image->image_url, $this->review->fresh('images')->main_image);
    }

    /** @test */
    public function itHasASocialImage()
    {
        $this->review->associateImage($image = $this->makeImage(), Image::IMAGE_CATEGORY_SOCIAL);

        $this->assertEquals($image->image_url, $this->review->fresh('images')->social_image);
    }

    /** @test */
    public function itCanSaveComments()
    {
        $this->build(Comment::class)
            ->on($this->review)
            ->create();

        $this->assertEquals(1, $this->review->allComments()->count());
    }

    protected function cacheKey(): string
    {
        return 'reviews';
    }

    protected function makeCachedModel(): void
    {
        $this->create(Review::class);
    }
}
