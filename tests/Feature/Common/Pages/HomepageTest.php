<?php

declare(strict_types=1);

namespace Tests\Feature\Common\Pages;

use Carbon\Carbon;
use Coeliac\Common\Models\Image;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\Recipe\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Str;
use Tests\TestCase;
use Tests\Traits\HasImages;

class HomepageTest extends TestCase
{
    use HasImages;

    /** @test */
    public function itLoadsTheHomePage()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function itHasTwoBlogs()
    {
        $this->build(Blog::class)
            ->state(new Sequence(
                [
                    'title' => 'First Blog',
                    'created_at' => Carbon::now()->subDays(3),
                ],
                [
                    'title' => 'Second Blog',
                    'created_at' => Carbon::now()->subDays(2),
                ],
                [
                    'title' => 'Third Blog',
                    'created_at' => Carbon::now()->subDay(),
                ]
            ))
            ->count(3)
            ->create()
            ->each(function (Blog $blog) {
                $filename = Str::slug($blog->title . ' image');

                $blog->associateImage($this->makeImage(['file_name' => $filename]), Image::IMAGE_CATEGORY_HEADER);
            });

        $this->get('/')
            ->assertSee('Second Blog')
            ->assertSee('Third Blog')
            ->assertDontSee('First Blog')
            ->assertSee('third-blog-image')
            ->assertSee('second-blog-image')
            ->assertDontSee('first-blog-image');
    }

    /** @test */
    public function itHasThreeRecipes()
    {
        $this->build(Recipe::class)
            ->state(new Sequence(
                [
                    'title' => 'First Recipe',
                    'created_at' => Carbon::now()->subDays(4),
                ],
                [
                    'title' => 'Second Recipe',
                    'created_at' => Carbon::now()->subDays(3),
                ],
                [
                    'title' => 'Third Recipe',
                    'created_at' => Carbon::now()->subDays(2),
                ],
                [
                    'title' => 'Fourth Recipe',
                    'created_at' => Carbon::now()->subDay(),
                ]
            ))
            ->count(4)
            ->create()
            ->each(function (Recipe $recipe) {
                $filename = Str::slug($recipe->title . ' image');

                $recipe->associateImage($this->makeImage(['file_name' => $filename]), Image::IMAGE_CATEGORY_SQUARE);
            });

        $this->get('/')
            ->assertSee('Fourth Recipe')
            ->assertSee('Third Recipe')
            ->assertSee('Second Recipe')
            ->assertDontSee('First Recipe')
            ->assertSee('fourth-recipe-image')
            ->assertSee('third-recipe-image')
            ->assertSee('second-recipe-image')
            ->assertDontSee('first-recipe-image');
    }
}
