<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Wheretoeat extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('wheretoeat', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('town_id');
            $table->unsignedInteger('county_id');
            $table->unsignedInteger('country_id');
            $table->text('info')->nullable()->default(null);
            $table->text('address');
            $table->string('phone', 50);
            $table->string('website');
            $table->string('lat', 50);
            $table->string('lng', 50);
            $table->unsignedInteger('type_id')->nullable();
            $table->unsignedInteger('venue_type_id')->nullable();
            $table->unsignedInteger('cuisine_id')->nullable();
            $table->boolean('live');
            $table->timestamps();

            $table->foreign('town_id')->references('id')->on('wheretoeat_towns');
            $table->foreign('county_id')->references('id')->on('wheretoeat_counties');
            $table->foreign('country_id')->references('id')->on('wheretoeat_countries');
            $table->foreign('type_id')->references('id')->on('wheretoeat_types');
            $table->foreign('venue_type_id')->references('id')->on('wheretoeat_venue_types');
            $table->foreign('cuisine_id')->references('id')->on('wheretoeat_cuisines');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('wheretoeat');
    }
}
