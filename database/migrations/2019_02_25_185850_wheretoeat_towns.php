<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WheretoeatTowns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wheretoeat_towns', function (Blueprint $table) {
            $table->increments('id');
            $table->string('town');
            $table->string('slug');
            $table->string('legacy');
            $table->unsignedInteger('county_id');
            $table->timestamps();

            $table->foreign('county_id')->references('id')->on('wheretoeat_counties');
            $table->unique(['slug', 'county_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wheretoeat_towns');
    }
}
