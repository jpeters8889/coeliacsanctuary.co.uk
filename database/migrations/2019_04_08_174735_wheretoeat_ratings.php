<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WheretoeatRatings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wheretoeat_ratings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('wheretoeat_id');
            $table->enum('rating', [1, 2, 3, 4, 5]);
            $table->string('ip', 39);
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->text('body')->nullable();
            $table->string('method', 50);
            $table->boolean('approved');
            $table->timestamps();

            $table->foreign('wheretoeat_id')->references('id')->on('wheretoeat')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('whereToEatRatings');
    }
}
