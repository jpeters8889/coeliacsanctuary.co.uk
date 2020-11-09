<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebhookCallsTable extends Migration
{
    public function up()
    {
        Schema::create('webhook_calls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('external_id')->nullable()->index();

            $table->string('name');
            $table->json('payload')->nullable();
            $table->text('exception')->nullable();
            $table->timestamp('processed_at')->nullable();

            $table->timestamps();
        });
    }
}
