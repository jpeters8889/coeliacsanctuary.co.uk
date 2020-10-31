<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShopPostageCountryAreas extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('shop_postage_country_areas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('area', 50);
            $table->string('delivery_timescale', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('shop_postage_country_areas');
    }
}
