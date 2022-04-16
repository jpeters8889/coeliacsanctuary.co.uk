<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\EatingOut\Reviews;

use Carbon\Carbon;
use Coeliac\Modules\Collection\Models\Collection;
use Coeliac\Modules\EatingOut\Reviews\Models\Review;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;
use Tests\Traits\HasImages;
use Coeliac\Common\Models\Image;
use Illuminate\Foundation\Testing\WithFaker;

class ReviewTest extends TestCase
{
    use HasImages;
    use WithFaker;

    /** @test */
    public function itLoadsTheReviewIndexPage()
    {
        $this->asAdmin()
            ->get('/review')
            ->assertStatus(200)
            ->assertSee('<module-list-index module="reviews" title="Reviews" url-prefix="review"', false);
    }

    /** @test */
    public function itLoadsTheReviewApiEndpoint()
    {
        $this->build(Review::class)
            ->count(13)
            ->sequence(fn ($sequence) => [
                'title' => "Review {$sequence->index}",
                'created_at' => Carbon::now()->subMonth()->addDay($sequence->index)
            ])
            ->create()
            ->each(
                fn (Review $review, $index) => $review->associateImage(
                    $this->makeImage(['file_name' => 'image-' . $index]),
                    Image::IMAGE_CATEGORY_HEADER
                )
            );

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

        for ($review = 12; $review > 0; --$review) {
            $request->assertSee('Review ' . $review, false);
            $request->assertSee('image-' . $review, false);
        }

        $request->assertDontSee('review-0');
        $request->assertDontSee('image-0');
    }

    /** @test */
    public function itOnlyShowsMatchingReviewsWhenFilteredByTags()
    {
        $this->build(Review::class)
            ->count(2)
            ->state(new Sequence(
                ['title' => 'Visible', 'wheretoeat_id' => $this->create(WhereToEat::class)->id],
                ['title' => 'Hidden', 'wheretoeat_id' => $this->create(WhereToEat::class, ['county_id' => $this->create(WhereToEatCounty::class)])->id],
            ))
            ->create();

        $this->get('/api/reviews?filter[counties]=' . WhereToEatCounty::query()->first()->county)
            ->assertSee('Visible', false)
            ->assertDontSee('Hidden');
    }

    /** @test */
    public function itOnlyShowsMatchingReviewsWhenFilteredByRating()
    {
        $this->build(Review::class)
            ->count(2)
            ->state(new Sequence(
                [
                    'title' => 'visible-review-title',
                    'knowledge_rating' => 5,
                    'presentation_taste_rating' => 5,
                    'value_rating' => 5,
                    'general_rating' => 5,
                ],
                [
                    'title' => 'hidden-review-title',
                    'knowledge_rating' => 3,
                    'presentation_taste_rating' => 3,
                    'value_rating' => 3,
                    'general_rating' => 3,
                ]
            ))
            ->create();

        $this->get('/api/reviews?filter[ratings]=5.0')
            ->assertSee('visible-review-title', false)
            ->assertDontSee('hidden-review-title');
    }

    /** @test */
    public function itShowsReviewContent()
    {
        $review = $this->create(Review::class)
            ->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_HEADER)
            ->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_SOCIAL);

        $this->asAdmin()
            ->get('/review/' . $review->slug)
            ->assertStatus(200)
            ->assertSee($review->title, false)
            ->assertSee($review->body, false)
            ->assertSee($review->main_image, false)
            ->assertSee($review->social_image, false);
    }

    /** @test */
    public function itDoesntLoadReviewsThatArentLive()
    {
        $review = $this->build(Review::class)->notLive()->create();

        $response = $this->get('/review/' . $review->slug);

        $response->assertNotFound();
    }
}
