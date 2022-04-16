<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wheretoeat_review_images', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedInteger('wheretoeat_review_id')->index();
            $table->unsignedInteger('wheretoeat_id')->index();
            $table->string('thumb', 256);
            $table->string('path', 256);
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
        Schema::dropIfExists('wheretoeat_review_images');
    }
};
