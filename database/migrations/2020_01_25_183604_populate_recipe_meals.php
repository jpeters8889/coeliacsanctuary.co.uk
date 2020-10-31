<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;

class PopulateRecipeMeals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Coeliac\Modules\Recipe\Models\RecipeMeal::query()->insert([
                ['meal' => 'Breakfast'],
                ['meal' => 'Lunch'],
                ['meal' => 'Dinner'],
                ['meal' => 'Dessert'],
                ['meal' => 'Snacks'],
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
