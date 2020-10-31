<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::dropIfExists('users');

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone', 255)->nullable();
            $table->string('password')->nullable();
            $table->string('api_token', 80)->unique()->nullable();
            $table->integer('user_level_id')->unsigned()->default(1);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('user_level_id')->references('id')->on('user_levels');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
