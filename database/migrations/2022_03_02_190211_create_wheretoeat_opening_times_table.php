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
        Schema::create('wheretoeat_opening_times', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('wheretoeat_id');
            $table->time('monday_start')->nullable()->default(null);
            $table->time('monday_end')->nullable()->default(null);
            $table->time('tuesday_start')->nullable()->default(null);
            $table->time('tuesday_end')->nullable()->default(null);
            $table->time('wednesday_start')->nullable()->default(null);
            $table->time('wednesday_end')->nullable()->default(null);
            $table->time('thursday_start')->nullable()->default(null);
            $table->time('thursday_end')->nullable()->default(null);
            $table->time('friday_start')->nullable()->default(null);
            $table->time('friday_end')->nullable()->default(null);
            $table->time('saturday_start')->nullable()->default(null);
            $table->time('saturday_end')->nullable()->default(null);
            $table->time('sunday_start')->nullable()->default(null);
            $table->time('sunday_end')->nullable()->default(null);
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
        Schema::dropIfExists('wheretoeat_opening_times');
    }
};
