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
        Schema::create('temporary_file_uploads', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('filename', 64);
            $table->string('path', 64);
            $table->string('source');
            $table->integer('filesize');
            $table->string('mime', 64);
            $table->dateTime('delete_at');
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
        Schema::dropIfExists('temporary_file_uploads');
    }
};
