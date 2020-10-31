<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RecipeNutrition extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe_nutrition', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('recipe_id');
            $table->integer('calories');
            $table->integer('carbs');
            $table->integer('fat');
            $table->integer('protein');
            $table->integer('fibre');
            $table->integer('sugar');
            $table->timestamps();

            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipe_nutrition');
    }
}
