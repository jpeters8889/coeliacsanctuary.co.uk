<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Recipes;

use Coeliac\Common\Models\Comment;
use Coeliac\Common\Models\Image;
use Coeliac\Modules\Recipe\Models\Recipe;
use Coeliac\Modules\Recipe\Models\RecipeAllergen;
use Coeliac\Modules\Recipe\Models\RecipeFeature;
use Coeliac\Modules\Recipe\Models\RecipeMeal;
use Coeliac\Modules\Recipe\Models\RecipeNutrition;
use Tests\TestCase;
use Tests\Traits\ClearsCache;
use Tests\Traits\HasImages;

class RecipeModelTest extends TestCase
{
    use ClearsCache;
    use HasImages;

    /** @var Recipe */
    private $recipe;

    public function setUp(): void
    {
        parent::setUp();

        $this->recipe = $this->build(Recipe::class)
            ->has($this->build(RecipeFeature::class), 'features')
            ->has($this->build(RecipeAllergen::class), 'allergens')
            ->has($this->build(RecipeMeal::class), 'meals')
            ->has($this->build(RecipeNutrition::class), 'nutrition')
            ->create();
    }

    /** @test */
    public function itHasAFeature()
    {
        $this->assertEquals(1, $this->recipe->features()->count());
    }

    /** @test */
    public function itHasAnAllergen()
    {
        $this->assertEquals(1, $this->recipe->allergens->count());
    }

    /** @test */
    public function itHasAMealType()
    {
        $this->assertEquals(1, $this->recipe->meals->count());
    }

    /** @test */
    public function itHasNutrition()
    {
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
        $this->build(Comment::class)
            ->on($this->recipe)
            ->create();

        $this->assertEquals(1, $this->recipe->allComments->count());
    }

    protected function cacheKey(): string
    {
        return 'recipes';
    }

    protected function makeCachedModel(): void
    {
        $this->create(Recipe::class);
    }
}
