<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Coeliac\Modules\Recipe\Models\RecipeAllergen;

class PopulateRecipeAllergens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RecipeAllergen::query()->insert([
            ['allergen' => 'Celery'],
            ['allergen' => 'Crustaceans'],
            ['allergen' => 'Dairy'],
            ['allergen' => 'Egg'],
            ['allergen' => 'Fish'],
            ['allergen' => 'Gluten'],
            ['allergen' => 'Lupin'],
            ['allergen' => 'Molluscs'],
            ['allergen' => 'Mustard'],
            ['allergen' => 'Peanuts'],
            ['allergen' => 'Sesame'],
            ['allergen' => 'Soya'],
            ['allergen' => 'Sulphites'],
            ['allergen' => 'Tree Nuts'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
