<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShopProducts extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('shop_products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 200);
            $table->boolean('pinned')->default(false);
            $table->text('meta_description');
            $table->text('meta_keywords');
            $table->string('slug', 200);
            $table->text('description');
            $table->text('long_description');
            $table->integer('shipping_method_id')->unsigned();
            $table->timestamps();

            $table->foreign('shipping_method_id')->references('id')->on('shop_shipping_methods');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('shop_products');
    }
}
