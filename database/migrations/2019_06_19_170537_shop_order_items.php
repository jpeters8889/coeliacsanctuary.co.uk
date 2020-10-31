<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShopOrderItems extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('shop_order_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('product_variant_id')->unsigned();
            $table->integer('quantity')->unsigned();
            $table->string('product_title');
            $table->integer('product_price');
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('shop_orders');
            $table->foreign('product_id')->references('id')->on('shop_products');
            $table->foreign('product_variant_id')->references('id')->on('shop_product_variants');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('shop_order_items');
    }
}
