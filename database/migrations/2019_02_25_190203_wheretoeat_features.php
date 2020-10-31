<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WheretoeatFeatures extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('wheretoeat_features', function (Blueprint $table) {
            $table->increments('id');
            $table->string('feature');
            $table->string('icon');
            $table->unsignedInteger('type_id')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('wheretoeat_features');
    }
}
