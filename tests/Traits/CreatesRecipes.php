<?php

declare(strict_types=1);

namespace Tests\Traits;

use Coeliac\Modules\Recipe\Models\Recipe;
use Coeliac\Modules\Recipe\Models\RecipeMeal;
use Coeliac\Modules\Recipe\Models\RecipeFeature;
use Coeliac\Modules\Recipe\Models\RecipeAllergen;
use Coeliac\Modules\Recipe\Models\RecipeNutrition;

trait CreatesRecipes
{
    protected function createRecipe($params = []): Recipe
    {
        return factory(Recipe::class)->create($params);
    }

    protected function createRecipeFeature($params = []): RecipeFeature
    {
        return factory(RecipeFeature::class)->create($params);
    }

    protected function createRecipeAllergen($params = []): RecipeAllergen
    {
        return factory(RecipeAllergen::class)->create($params);
    }

    protected function createRecipeMeal($params = []): RecipeMeal
    {
        return factory(RecipeMeal::class)->create($params);
    }

    protected function createRecipeNutrition($params = []): RecipeNutrition
    {
        return factory(RecipeNutrition::class)->create($params);
    }
}
