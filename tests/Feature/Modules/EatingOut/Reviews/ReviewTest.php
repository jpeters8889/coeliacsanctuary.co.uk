<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\EatingOut\Reviews;

use Carbon\Carbon;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;
use Tests\TestCase;
use Tests\Traits\HasImages;
use Coeliac\Common\Models\Image;
use Tests\Traits\CreatesReviews;
use Tests\Traits\CreatesWhereToEat;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReviewTest extends TestCase
{
    use CreatesWhereToEat;
    use CreatesReviews;
    use HasImages;
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function itLoadsTheReviewIndexPage()
    {
        $this->get('/review')
            ->assertStatus(200)
            ->assertSee('<module-list-index module="reviews" title="Reviews" url-prefix="review">', false);
    }

    /** @test */
    public function itLoadsTheReviewApiEndpoint()
    {
        for ($review = 0; $review < 13; ++$review) {
            $this->createReview([
                'title' => 'review-'.$review,
                'created_at' => Carbon::now()->subDays($review),
            ])
                ->associateImage($this->makeImage(['file_name' => 'image-'.$review]), Image::IMAGE_CATEGORY_HEADER);
        }

        $request = $this->get('/api/reviews');

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

        for ($review = 0; $review < 12; ++$review) {
            $request->assertSee('review-'.$review, false);
            $request->assertSee('image-'.$review, false);
        }

        $request->assertDontSee('review-12');
        $request->assertDontSee('image-12');
    }

    /** @test */
    public function itOnlyShowsMatchingReviewsWhenFilteredByTags()
    {
        $county = factory(WhereToEatCounty::class)->create(['country_id' => 1]);
        $hiddenCounty = factory(WhereToEatCounty::class)->create(['country_id' => 1]);

        $this->createReview(['title' => 'visible-review-title'], ['county_id' => $county->id]);
        $this->createReview(['title' => 'hidden-review-title'], ['county_id' => $hiddenCounty->id]);

        $this->get('/api/reviews?filter[counties]='.$county->county)
            ->assertSee('visible-review-title', false)
            ->assertDontSee('hidden-review-title');
    }

    /** @test */
    public function itOnlyShowsMatchingReviewsWhenFilteredByRating()
    {
        $this->createReview([
            'title' => 'visible-review-title',
            'knowledge_rating' => 5,
            'presentation_taste_rating' => 5,
            'value_rating' => 5,
            'general_rating' => 5,
        ]);

        $this->createReview([
            'title' => 'hidden-review-title',
            'knowledge_rating' => 3,
            'presentation_taste_rating' => 3,
            'value_rating' => 3,
            'general_rating' => 3,
        ]);

        $this->get('/api/reviews?filter[ratings]=5.0')
            ->assertSee('visible-review-title', false)
            ->assertDontSee('hidden-review-title');
    }

    /** @test */
    public function itShowsReviewContent()
    {
        $review = $this->createReview();

        $review->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_HEADER)
            ->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_SOCIAL);

        $this->get('/review/'.$review->slug)
            ->assertStatus(200)
            ->assertSee($review->title, false)
            ->assertSee($review->body, false)
            ->assertSee($review->main_image, false)
            ->assertSee($review->social_image, false);
    }

    /** @test */
    public function itDoesntLoadReviewsThatArentLive()
    {
        $this->withExceptionHandling();
        $review = $this->createReview(['live' => false]);

        $response = $this->get('/review/'.$review->slug);

        $response->assertNotFound();
    }
}
