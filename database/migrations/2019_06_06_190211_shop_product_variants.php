<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShopProductVariants extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('shop_product_variants', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id');
            $table->boolean('live')->default(false);
            $table->string('title');
            $table->integer('weight')->unsigned();
            $table->integer('quantity')->unsigned();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('shop_products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('shop_product_variants');
    }
}
