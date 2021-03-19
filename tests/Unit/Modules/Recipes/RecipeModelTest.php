<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Recipes;

use Tests\TestCase;
use Tests\Traits\HasImages;
use Coeliac\Common\Models\Image;
use Tests\Traits\CreatesRecipes;
use Coeliac\Common\Models\Comment;
use Tests\Traits\ClearingCacheTest;
use Coeliac\Modules\Recipe\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecipeModelTest extends TestCase
{
    use ClearingCacheTest;
    use CreatesRecipes;
    use HasImages;
    use RefreshDatabase;

    /** @var Recipe */
    private $recipe;

    public function setUp(): void
    {
        parent::setUp();

        $this->recipe = $this->createRecipe();
    }

    /** @test */
    public function itHasAFeature()
    {
        $this->recipe->features()->attach($this->createRecipeFeature());
        $this->assertEquals(1, $this->recipe->features()->count());
    }

    /** @test */
    public function itHasAnAllergen()
    {
        $this->recipe->allergens()->attach($this->createRecipeAllergen());
        $this->assertEquals(1, $this->recipe->allergens->count());
    }

    /** @test */
    public function itHasAMealType()
    {
        $this->recipe->meals()->attach($this->createRecipeMeal());
        $this->assertEquals(1, $this->recipe->meals->count());
    }

    /** @test */
    public function itHasNutrition()
    {
        $this->createRecipeNutrition(['recipe_id' => $this->recipe->id]);
        $this->assertEquals(1, $this->recipe->nutrition->count());
    }

    /** @test */
    public function itHasAnImage()
    {
        $this->recipe->associateImage($this->makeImage());
        $this->assertEquals(1, $this->recipe->images->count());
    }

    /** @test */
    public function itHasAMainImage()
    {
        $this->recipe->associateImage($image = $this->makeImage(), Image::IMAGE_CATEGORY_HEADER);

        $this->assertEquals($image->image_url, $this->recipe->main_image);
    }

    /** @test */
    public function itHasASquareImage()
    {
        $this->recipe->associateImage($image = $this->makeImage(), Image::IMAGE_CATEGORY_SQUARE);

        $this->assertEquals($image->image_url, $this->recipe->square_image);
    }

    /** @test */
    public function itHasASocialImage()
    {
        $this->recipe->associateImage($image = $this->makeImage(), Image::IMAGE_CATEGORY_SOCIAL);

        $this->assertEquals($image->image_url, $this->recipe->social_image);
    }

    /** @test */
    public function itCanSaveComments()
    {
        $comment = factory(Comment::class)->create([
            'commentable_id' => $this->recipe->id,
            'commentable_type' => Recipe::class,
        ]);

        $this->recipe->comments()->save($comment);

        $this->assertEquals(1, $this->recipe->allComments->count());
    }

    protected function cacheKey(): string
    {
        return 'recipes';
    }

    protected function makeCachedModel(): void
    {
        $this->createRecipe();
    }
}
