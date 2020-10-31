<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShopPostageCountries extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('shop_postage_countries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('postage_area_id')->unsigned();
            $table->string('country', 50);
            $table->string('iso_code', 2);
            $table->timestamps();

            $table->foreign('postage_area_id')->references('id')->on('shop_postage_country_areas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('shop_postage_countries');
    }
}
