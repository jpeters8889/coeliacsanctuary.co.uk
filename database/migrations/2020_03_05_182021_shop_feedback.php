<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShopFeedback extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('shop_feedback', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->text('feedback');
            $table->unsignedInteger('product_id');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('shop_products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('shop_feedback');
    }
}
