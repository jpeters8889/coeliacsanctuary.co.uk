<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShopPaymentTypes extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('shop_payment_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('shop_payment_types');
    }
}
