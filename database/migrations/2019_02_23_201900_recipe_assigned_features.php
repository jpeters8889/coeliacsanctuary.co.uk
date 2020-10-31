<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RecipeAssignedFeatures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe_assigned_features', function (Blueprint $table) {
            $table->primary(['recipe_id', 'feature_type_id']);
            $table->unsignedInteger('recipe_id');
            $table->unsignedInteger('feature_type_id');
            $table->timestamps();

            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');
            $table->foreign('feature_type_id')->references('id')->on('recipe_features');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipe_assigned_features');
    }
}
