<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Attractionrestaurants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attraction_restaurants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('wheretoeat_id')->unsigned();
            $table->string('restaurant_name', 255);
            $table->text('info');
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
        Schema::dropIfExists('attraction_restaurants');
    }
}
