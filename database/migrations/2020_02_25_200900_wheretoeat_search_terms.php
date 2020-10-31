<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WheretoeatSearchTerms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wheretoeat_search_terms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key', 16)->unique();
            $table->string('term');
            $table->tinyInteger('range')->default(2)->unsigned();
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
        Schema::dropIfExists('wheretoeat_search_terms');
    }
}
