<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SearchHistory extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('search_history', function (Blueprint $table) {
            $table->increments('id');
            $table->string('term', 50);
            $table->boolean('blogs')->default(true);
            $table->boolean('recipes')->default(true);
            $table->boolean('reviews')->default(true);
            $table->boolean('eateries')->default(true);
            $table->boolean('products')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('search_history');
    }
}
