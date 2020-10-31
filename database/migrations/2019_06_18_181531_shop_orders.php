<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShopOrders extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('shop_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('state_id')->unsigned()->default(1);
            $table->integer('postage_country_id')->unsigned()->default(1);
            $table->string('token', 16);
            $table->string('order_key')->nullable()->default(null);
            $table->integer('user_id')->unsigned()->nullable()->default(null);
            $table->integer('user_address_id')->unsigned()->nullable()->default(null);
            $table->dateTime('shipped_at')->nullable()->default(null);
            $table->boolean('newsletter_signup')->default(false);
            $table->timestamps();

            $table->foreign('state_id')->references('id')->on('shop_order_states');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('user_address_id')->references('id')->on('user_addresses');
            $table->foreign('postage_country_id')->references('id')->on('shop_postage_countries');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('shop_orders');
    }
}
