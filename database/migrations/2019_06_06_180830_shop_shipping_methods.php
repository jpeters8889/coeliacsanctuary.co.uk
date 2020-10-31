<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShopShippingMethods extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('shop_shipping_methods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('shipping_method');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('shop_shipping_methods');
    }
}
