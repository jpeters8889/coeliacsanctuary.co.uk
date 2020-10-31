<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RecipeAssignedAllergens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe_assigned_allergens', function (Blueprint $table) {
            $table->primary(['recipe_id', 'allergen_type_id']);
            $table->unsignedInteger('recipe_id');
            $table->unsignedInteger('allergen_type_id');
            $table->timestamps();

            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');
            $table->foreign('allergen_type_id')->references('id')->on('recipe_allergens')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipe_assigned_allergens');
    }
}
