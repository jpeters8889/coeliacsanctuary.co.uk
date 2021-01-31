<?php

declare(strict_types=1);

namespace Tests\Feature;

use Coeliac\Common\Models\Image;
use Illuminate\Support\Str;
use Tests\TestCase;
use Tests\Traits\CreatesRecipes;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\HasImages;

class RecipePrefixCommandTest extends TestCase
{
    use RefreshDatabase;
    use CreatesRecipes;
    use HasImages;

    /** @test */
    public function itAsksForConfirmationWhenRunningInProdMode()
    {
        $this->artisan('coeliac:prefix-recipes --prod')
            ->expectsConfirmation('This is set to run in production mode, are you sure?');
    }

    /** @test */
    public function itDoesntUpdateRowsWhenExitingInProdMode()
    {
        $recipe = $this->createRecipe();

        $this->artisan('coeliac:prefix-recipes --prod')
            ->expectsConfirmation('This is set to run in production mode, are you sure?')
            ->assertExitCode(0);

        $this->assertTrue($recipe->is($recipe->fresh()));
    }

    /** @test */
    public function it_doesnt_do_anything_if_there_are_no_recipes()
    {
        $this->artisan('coeliac:prefix-recipes')
            ->assertExitCode(0);
    }

    /** @test */
    public function it_shows_the_title()
    {
        $recipe = $this->createRecipe();

        $this->artisan('coeliac:prefix-recipes')
            ->expectsOutput("Processing {$recipe->title}");
    }

    /** @test */
    public function it_prepares_to_set_the_legacy_slug()
    {
        $recipe = $this->createRecipe();

        $this->artisan('coeliac:prefix-recipes')
            ->expectsOutput('Setting the legacy slug')
            ->expectsOutput("Legacy slug for redirects is '{$recipe->slug}'");
    }

    /** @test */
    public function it_prepares_to_prefix_title()
    {
        $recipe = $this->createRecipe();

        $this->artisan('coeliac:prefix-recipes')
            ->expectsOutput('Prefixing the title...')
            ->expectsOutput("New title is 'Gluten Free {$recipe->title}'");
    }

    /** @test */
    public function it_prepares_to_set_the_updated_slug()
    {
        $recipe = $this->createRecipe();

        $expectedSlug = Str::slug("Gluten Free {$recipe->title}");

        $this->artisan('coeliac:prefix-recipes')
            ->expectsOutput('updating the slug')
            ->expectsOutput("New slug is '{$expectedSlug}'");
    }

    /** @test */
    public function it_shows_a_linebreak_between_each_row()
    {
        $this->createRecipe();

        $this->artisan('coeliac:prefix-recipes')
            ->expectsOutput('--------');
    }

    /** @test */
    public function it_errors_if_the_title_already_has_gluten_free_in_the_title()
    {
        $this->createRecipe(['title' => 'Gluten Free']);

        $this->artisan('coeliac:prefix-recipes')
            ->expectsOutput("Gluten Free already contains 'gluten free', skipping...");
    }

    /** @test */
    public function it_shows_a_summary_at_the_end()
    {
        $this->createRecipe();
        $this->createRecipe();
        $this->createRecipe(['title' => 'Gluten Free']);

        $this->artisan('coeliac:prefix-recipes')
            ->expectsTable([], [
                ['Total Recipes', 3],
                ['Recipes Updated', 2],
                ['Recipes Skipped', 1],
            ]);
    }

    /** @test */
    public function it_continues_the_routine_in_prodution_mode()
    {
        $recipe = $this->createRecipe();

        $expectedSlug = Str::slug("Gluten Free {$recipe->title}");

        $this->artisan('coeliac:prefix-recipes --prod')
            ->expectsConfirmation('This is set to run in production mode, are you sure?', 'yes')
            ->expectsOutput("Processing {$recipe->title}")
            ->expectsOutput('Setting the legacy slug')
            ->expectsOutput("Legacy slug for redirects is '{$recipe->slug}'")
            ->expectsOutput('Prefixing the title...')
            ->expectsOutput("New title is 'Gluten Free {$recipe->title}'")
            ->expectsOutput('updating the slug')
            ->expectsOutput("New slug is '{$expectedSlug}'")
            ->expectsOutput('--------')
            ->expectsTable([], [
                ['Total Recipes', 1],
                ['Recipes Updated', 1],
                ['Recipes Skipped', 0],
            ]);
    }

    /** @test */
    public function it_doesnt_update_recipes_that_already_have_gluten_free_in_production_mode()
    {
        $recipe = $this->createRecipe(['title' => 'Gluten Free']);

        $this->artisan('coeliac:prefix-recipes --prod')
            ->expectsConfirmation('This is set to run in production mode, are you sure?', 'yes')
            ->expectsOutput("Gluten Free already contains 'gluten free', skipping...");

        $this->assertTrue($recipe->is($recipe->fresh()));
    }

    /** @test */
    public function it_updates_the_recipe_in_production_mode()
    {
        $recipe = $this->createRecipe();

        $expectedSlug = Str::slug("Gluten Free {$recipe->title}");

        $this->artisan('coeliac:prefix-recipes --prod')
            ->expectsConfirmation('This is set to run in production mode, are you sure?', 'yes');

        $updatedRecipe = $recipe->fresh();

        $this->assertNull($recipe->legacy_slug);
        $this->assertNotNull($updatedRecipe->legacy_slug);
        $this->assertEquals($recipe->slug, $updatedRecipe->legacy_slug);
        $this->assertEquals("Gluten Free {$recipe->title}", $updatedRecipe->title);
        $this->assertEquals($expectedSlug, $updatedRecipe->slug);
    }

    /** @test */
    public function it_redirects_to_the_new_page_when_loading_the_legacy_slug()
    {
        $recipe = $this->createRecipe();
        $this->createRecipeNutrition(['recipe_id' => 1]);

        $recipe->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_HEADER);
        $recipe->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_SOCIAL);

        $this->get("/recipe/{$recipe->slug}")->assertStatus(200);

        $this->artisan('coeliac:prefix-recipes --prod')
            ->expectsConfirmation('This is set to run in production mode, are you sure?', 'yes');

        $recipe->refresh();

        $this->get("/recipe/{$recipe->slug}")->assertStatus(200);
        $this->get("/recipe/{$recipe->legacy_slug}")->assertRedirect("/recipe/{$recipe->slug}");
    }
}
