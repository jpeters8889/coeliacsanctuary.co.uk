<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShopProductCategories extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('shop_product_categories', function (Blueprint $table) {
            $table->integer('category_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->timestamps();

            $table->primary(['category_id', 'product_id']);
            $table->foreign('category_id')->references('id')->on('shop_categories');
            $table->foreign('product_id')->references('id')->on('shop_products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('shop_product_categories');
    }
}
