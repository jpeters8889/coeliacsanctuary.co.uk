<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WheretoeatCounties extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wheretoeat_counties', function (Blueprint $table) {
            $table->increments('id');
            $table->string('county');
            $table->string('slug');
            $table->string('legacy')->collation('utf8_bin');
            $table->unsignedInteger('country_id');
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('wheretoeat_countries');
            $table->unique(['slug', 'country_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wheretoeat_counties');
    }
}
