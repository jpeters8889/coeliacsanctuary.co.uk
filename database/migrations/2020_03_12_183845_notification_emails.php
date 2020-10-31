<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NotificationEmails extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('notification_emails', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('key');
            $table->unsignedInteger('user_id');
            $table->string('template', 128);
            $table->text('data');
            $table->timestamps();

//            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('notification_emails');
    }
}
