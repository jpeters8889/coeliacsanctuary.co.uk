<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWheretoeatPlaceRecommendationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wheretoeat_place_recommendation', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('place_name');
            $table->text('place_location');
            $table->string('place_web_address')->nullable();
            $table->unsignedInteger('place_venue_type_id')->nullable();
            $table->text('place_details');
            $table->boolean('completed')->default(false);
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
        Schema::dropIfExists('wheretoeat_place_recommendation');
    }
}
