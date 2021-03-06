<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\EatingOut\Reviews;

use Tests\TestCase;
use Tests\Traits\HasImages;
use Coeliac\Common\Models\Image;
use Tests\Traits\CreatesReviews;
use Coeliac\Common\Models\Comment;
use Tests\Traits\ClearingCacheTest;
use Tests\Traits\CreatesWhereToEat;
use Coeliac\Modules\Blog\Models\Blog;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\EatingOut\Reviews\Models\Review;

class ReviewModelTest extends TestCase
{
    use ClearingCacheTest;
    use CreatesReviews;
    use CreatesWhereToEat;
    use HasImages;
    use RefreshDatabase;
    use WithFaker;

    /** @var Review */
    private $review;

    public function setUp(): void
    {
        parent::setUp();

        $this->review = $this->createReview();
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
        $comment = factory(Comment::class)->create([
            'commentable_id' => $this->review->id,
            'commentable_type' => Blog::class,
        ]);

        $this->review->comments()->save($comment);

        $this->assertEquals(1, $this->review->allComments()->count());
    }

    protected function cacheKey(): string
    {
        return 'reviews';
    }

    protected function makeCachedModel(): void
    {
        $this->createReview();
    }
}
