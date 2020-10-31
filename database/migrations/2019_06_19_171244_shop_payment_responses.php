<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShopPaymentResponses extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('shop_payment_responses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('payment_id');
            $table->text('response');
            $table->timestamps();

            $table->foreign('payment_id')->references('id')->on('shop_payments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('shop_payment_responses');
    }
}
