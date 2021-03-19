<?php

declare(strict_types=1);

namespace Tests\Feature\Common\Pages;

use Carbon\Carbon;
use Tests\TestCase;
use Tests\Traits\HasImages;
use Tests\Traits\CreatesBlogs;
use Coeliac\Common\Models\Image;
use Tests\Traits\CreatesRecipes;
use Tests\Traits\CreatesReviews;
use Tests\Traits\CreatesWhereToEat;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomepageTest extends TestCase
{
    use CreatesBlogs;
    use CreatesRecipes;
    use CreatesReviews;
    use CreatesWhereToEat;
    use HasImages;
    use RefreshDatabase;

    /** @test */
    public function itLoadsTheHomePage()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function itHasTwoBlogs()
    {
        $this->createBlog([
            'title' => 'First Blog',
            'created_at' => Carbon::now()->subDays(3),
        ])->associateImage($this->makeImage(['file_name' => 'first-blog-image']), Image::IMAGE_CATEGORY_HEADER);

        $this->createBlog([
            'title' => 'Second Blog',
            'created_at' => Carbon::now()->subDays(2),
        ])->associateImage($this->makeImage(['file_name' => 'second-blog-image']), Image::IMAGE_CATEGORY_HEADER);

        $this->createBlog([
            'title' => 'Third Blog',
            'created_at' => Carbon::now()->subDays(1),
        ])->associateImage($this->makeImage(['file_name' => 'third-blog-image']), Image::IMAGE_CATEGORY_HEADER);

        $response = $this->get('/');

        $response->assertSee('Second Blog', false);
        $response->assertSee('Third Blog', false);
        $response->assertDontSee('First Blog');

        $response->assertSee('third-blog-image', false);
        $response->assertSee('second-blog-image', false);
        $response->assertDontSee('first-blog-image');
    }

    /** @test */
    public function itHasThreeRecipes()
    {
        $this->createRecipe([
            'title' => 'First Recipe',
            'created_at' => Carbon::now()->subDays(3),
        ])->associateImage($this->makeImage(['file_name' => 'first-rec-image']), Image::IMAGE_CATEGORY_SQUARE);

        $this->createRecipe([
            'title' => 'Second Recipe',
            'created_at' => Carbon::now()->subDays(2),
        ])->associateImage($this->makeImage(['file_name' => 'second-rec-image']), Image::IMAGE_CATEGORY_SQUARE);

        $this->createRecipe([
            'title' => 'Third Recipe',
            'created_at' => Carbon::now()->subDays(1),
        ])->associateImage($this->makeImage(['file_name' => 'third-rec-image']), Image::IMAGE_CATEGORY_SQUARE);

        $this->createRecipe([
            'title' => 'Fourth Recipe',
            'created_at' => Carbon::now(),
        ])->associateImage($this->makeImage(['file_name' => 'fourth-rec-image']), Image::IMAGE_CATEGORY_SQUARE);

        $response = $this->get('/');

        $response->assertSee('Fourth Recipe', false);
        $response->assertSee('Third Recipe', false);
        $response->assertSee('Second Recipe', false);
        $response->assertDontSee('First Recipe');

        $response->assertSee('fourth-rec-image', false);
        $response->assertSee('third-rec-image', false);
        $response->assertSee('second-rec-image', false);
        $response->assertDontSee('first-rec-image');
    }

    /** @test */
    public function itHasTwoReviews()
    {
        $this->createReview([
            'title' => 'First Review',
            'created_at' => Carbon::now()->subDays(2),
        ])->associateImage($this->makeImage(['file_name' => 'first-rev-image']), Image::IMAGE_CATEGORY_HEADER);

        $this->createReview([
            'title' => 'Second Review',
            'created_at' => Carbon::now()->subDays(1),
        ])->associateImage($this->makeImage(['file_name' => 'second-rev-image']), Image::IMAGE_CATEGORY_HEADER);

        $this->createReview([
            'title' => 'Third Review',
            'created_at' => Carbon::now(),
        ])->associateImage($this->makeImage(['file_name' => 'third-rev-image']), Image::IMAGE_CATEGORY_HEADER);

        $response = $this->get('/');

        $response->assertSee('Third Review', false);
        $response->assertSee('Second Review', false);
        $response->assertDontSee('First Review');

        $response->assertSee('third-rev-image', false);
        $response->assertSee('second-rev-image', false);
        $response->assertDontSee('first-rev-image');
    }
}
