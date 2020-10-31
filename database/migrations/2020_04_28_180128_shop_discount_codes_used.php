<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShopDiscountCodesUsed extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_discount_codes_used', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('discount_id');
            $table->unsignedInteger('order_id');
            $table->unsignedInteger('discount_amount');
            $table->timestamps();

            $table->foreign('discount_id')->references('id')->on('shop_discount_codes');
            $table->foreign('order_id')->references('id')->on('shop_orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_discount_codes_used');
    }
}
