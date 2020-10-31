<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserAddresses extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->enum('type', ['Billing', 'Shipping']);
            $table->string('name', 255);
            $table->string('line_1', 255);
            $table->string('line_2', 255)->nullable()->default(null);
            $table->string('line_3', 255)->nullable()->default(null);
            $table->string('town', 255);
            $table->string('postcode', 16);
            $table->string('country', 255);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('user_addresses');
    }
}
