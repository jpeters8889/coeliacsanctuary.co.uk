<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShopDiscountCodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_discount_codes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_id')->default(1);
            $table->string('name');
            $table->string('code', 50);
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->integer('max_claims')->default(0);
            $table->integer('min_spend')->nullable();
            $table->integer('deduction');
            $table->timestamps();

            $table->foreign('type_id')->references('id')->on('shop_discount_code_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_discount_codes');
    }
}
