<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WheretoeatSearches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wheretoeat_searches', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('search_term_id')->unsigned();
            $table->timestamps();

            $table->foreign('search_term_id')->references('id')->on('wheretoeat_search_terms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wheretoeat_searches');
    }
}
