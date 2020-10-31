<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShopPayments extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('shop_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->integer('subtotal')->unsigned();
            $table->integer('discount')->unsigned();
            $table->integer('postage')->unsigned();
            $table->integer('total')->unsigned();
            $table->integer('payment_type_id')->unsigned();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('shop_orders');
            $table->foreign('payment_type_id')->references('id')->on('shop_payment_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('shop_payments');
    }
}
