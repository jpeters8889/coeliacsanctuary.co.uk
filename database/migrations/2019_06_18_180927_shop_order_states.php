<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShopOrderStates extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('shop_order_states', function (Blueprint $table) {
            $table->increments('id');
            $table->string('state');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('shop_order_states');
    }
}
