<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wheretoeat_reviews', function (Blueprint $table) {
            $table->enum('food_rating', ['poor','good','excellent'])->after('how_expensive')->nullable()->default(null);
            $table->enum('service_rating', ['poor','good','excellent'])->after('food_rating')->nullable()->default(null);
        });
    }
};
