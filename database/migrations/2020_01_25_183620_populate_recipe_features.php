<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Coeliac\Modules\Recipe\Models\RecipeFeature;

class PopulateRecipeFeatures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RecipeFeature::query()->insert([
            ['feature' => 'Alcohol Free', 'icon' => 'alcoholFree'],
            ['feature' => 'Dairy Free', 'icon' => 'dairyFree'],
            ['feature' => 'Egg Free', 'icon' => 'eggFree'],
            ['feature' => 'FODMAP Friendly', 'icon' => 'fodmap'],
            ['feature' => 'High Fibre', 'icon' => 'highFibre'],
            ['feature' => 'High Protein', 'icon' => 'highProtein'],
            ['feature' => 'Low Calorie', 'icon' => 'lowCalorie'],
            ['feature' => 'Low Fat', 'icon' => 'lowFat'],
            ['feature' => 'Low Sugar', 'icon' => 'lowSugar'],
            ['feature' => 'Nut Free', 'icon' => 'nutFree'],
            ['feature' => 'Soya Free', 'icon' => 'soyaFree'],
            ['feature' => 'Slimming World Friendly', 'icon' => 'sw'],
            ['feature' => 'Vegan', 'icon' => 'vegan'],
            ['feature' => 'Vegetarian', 'icon' => 'vegetarian'],
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
