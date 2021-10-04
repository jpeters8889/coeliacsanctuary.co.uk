<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Recipes;

use Carbon\Carbon;
use Coeliac\Modules\Recipe\Models\Recipe;
use Coeliac\Modules\Recipe\Models\RecipeAllergen;
use Coeliac\Modules\Recipe\Models\RecipeFeature;
use Coeliac\Modules\Recipe\Models\RecipeMeal;
use Coeliac\Modules\Recipe\Models\RecipeNutrition;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;
use Tests\Traits\HasImages;
use Coeliac\Common\Models\Image;
use Illuminate\Foundation\Testing\WithFaker;

class RecipeTest extends TestCase
{
    use HasImages;
    use WithFaker;

    /** @test */
    public function itLoadsTheRecipeIndexPage()
    {
        $this->get('/recipe')
            ->assertStatus(200)
            ->assertSee('<module-list-index module="recipes" title="Recipes" url-prefix="recipe"', false);
    }

    /** @test */
    public function itLoadsTheRecipeApiEndpoint()
    {
        $this->build(Recipe::class)
            ->count(13)
            ->sequence(fn ($sequence) => [
                'created_at' => Carbon::now()->subMonth()->addDay($sequence->index),
                'title' => "Recipe {$sequence->index}"
            ])
            ->create()
            ->each(
                fn (Recipe $recipe, $index) => $recipe->associateImage($this->makeImage(['file_name' => 'image-' . $index]), Image::IMAGE_CATEGORY_HEADER)
            );

        $request = $this->get('/api/recipes');

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

        for ($recipe = 12; $recipe > 0; --$recipe) {
            $request->assertSee('Recipe ' . $recipe, false);
            $request->assertSee('image-' . $recipe, false);
        }

        $request->assertDontSee('recipe-0');
        $request->assertDontSee('image-0');
    }

    /** @test */
    public function itOnlyShowsMatchingRecipesWhenFilteredByFeature()
    {
        [$visibleRecipe, $hiddenRecipe] = $this->build(Recipe::class)
            ->count(2)
            ->state(new Sequence(
                ['title' => 'Visible Recipe'],
                ['title' => 'Hidden Recipe']
            ))
            ->create();

        $visibleRecipe->features()->attach($this->create(RecipeFeature::class, ['feature' => 'visible']));
        $hiddenRecipe->features()->attach($this->create(RecipeFeature::class, ['feature' => 'hidden']));

        $this->get('/api/recipes?filter[feature]=visible')
            ->assertSee('Visible Recipe', false)
            ->assertDontSee('Hidden Recipe');
    }

    /** @test */
    public function itOnlyShowsMatchingRecipesWhenFilteredByFreefrom()
    {
        [$visibleRecipe, $hiddenRecipe] = $this->build(Recipe::class)
            ->count(2)
            ->state(new Sequence(
                ['title' => 'Visible Recipe'],
                ['title' => 'Hidden Recipe']
            ))
            ->create();

        $visibleRecipe->allergens()->attach($this->create(RecipeAllergen::class, ['allergen' => 'visible']));
        $hiddenRecipe->allergens()->attach($this->create(RecipeAllergen::class, ['allergen' => 'hidden']));

        $this->get('/api/recipes?filter[freefrom]=visible')
            ->assertSee('Visible Recipe', false)
            ->assertDontSee('Hidden Recipe');
    }

    /** @test */
    public function itOnlyShowsMatchingRecipesWhenFilteredByMeal()
    {
        [$visibleRecipe, $hiddenRecipe] = $this->build(Recipe::class)
            ->count(2)
            ->state(new Sequence(
                ['title' => 'Visible Recipe'],
                ['title' => 'Hidden Recipe']
            ))
            ->create();

        $visibleRecipe->meals()->attach($this->create(RecipeMeal::class, ['meal' => 'visible']));
        $hiddenRecipe->meals()->attach($this->create(RecipeMeal::class, ['meal' => 'hidden']));

        $this->get('/api/recipes?filter[meal]=visible')
            ->assertSee('Visible Recipe', false)
            ->assertDontSee('Hidden Recipe');
    }

    /** @test */
    public function itShowsRecipeContent()
    {
        $recipe = $this->build(Recipe::class)
            ->has($this->build(RecipeNutrition::class), 'nutrition')
            ->create()
            ->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_HEADER)
            ->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_SOCIAL);

        $this->get('/recipe/' . $recipe->slug)
            ->assertStatus(200)
            ->assertSee($recipe->title, false)
            ->assertSee($recipe->ingredients, false)
            ->assertSee($recipe->method, false)
            ->assertSee($recipe->main_image, false)
            ->assertSee($recipe->social_image, false);
    }

    /** @test */
    public function itDoesntLoadRecipesThatArentLive()
    {
        $recipe = $this->build(Recipe::class)
            ->notLive()
            ->create();

        $response = $this->get('/recipe/' . $recipe->slug);

        $response->assertNotFound();
    }
}
