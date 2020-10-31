<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Reviews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('wheretoeat_id');
            $table->string('title', 200);
            $table->string('slug', 200)->unique();
            $table->string('legacy_slug');
            $table->text('body');
            $table->decimal('overall_rating', 5, 1);
            $table->decimal('knowledge_rating', 5, 1);
            $table->decimal('presentation_taste_rating', 5, 1);
            $table->decimal('value_rating', 5, 1);
            $table->decimal('general_rating', 5, 1);
            $table->text('meta_tags');
            $table->text('meta_description');
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
        Schema::dropIfExists('reviews');
    }
}
