<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Recipes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 200);
            $table->string('slug', 200)->unique();
            $table->text('meta_tags');
            $table->text('meta_description');
            $table->text('description');
            $table->text('ingredients');
            $table->text('method');
            $table->string('author');
            $table->string('category')->default('Gluten Free');
            $table->string('serving_size', 50);
            $table->string('per', 50);
            $table->text('search_tags');
            $table->string('df_to_not_df', 255)->default('');
            $table->string('prep_time', 50);
            $table->string('cook_time', 50);
            $table->boolean('live');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipes');
    }
}
