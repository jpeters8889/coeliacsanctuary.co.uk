<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScrapbookItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scrapbook_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scrapbook_id')->references('id')->on('scrapbooks')->cascadeOnDelete();
            $table->morphs('item');
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
        Schema::dropIfExists('scrapbook_items');
    }
}
