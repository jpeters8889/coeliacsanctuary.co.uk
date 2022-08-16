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
        Schema::create('shop_order_review_invitations', function (Blueprint $table) {
            $table->uuid('id')->unique()->index();
            $table->boolean('sent')->default(false);
            $table->bigInteger('order_id');
            $table->dateTime('sent_at')->nullable()->default(null);
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
        Schema::dropIfExists('shop_order_review_invitations');
    }
};
