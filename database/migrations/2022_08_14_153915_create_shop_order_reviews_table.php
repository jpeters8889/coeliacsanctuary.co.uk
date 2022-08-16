<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_order_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->index()->nullable()->default(null);
            $table->uuid('invitation_id')->index()->nullable()->default(null);
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_order_reviews');
    }
};
