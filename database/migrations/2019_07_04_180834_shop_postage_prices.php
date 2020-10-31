<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShopPostagePrices extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('shop_postage_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('postage_country_area_id');
            $table->unsignedInteger('shipping_method_id');
            $table->unsignedInteger('max_weight');
            $table->integer('price');
            $table->timestamps();

            $table->foreign('postage_country_area_id')->references('id')->on('shop_postage_country_areas');
            $table->foreign('shipping_method_id')->references('id')->on('shop_shipping_methods');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('shop_postage_prices');
    }
}
