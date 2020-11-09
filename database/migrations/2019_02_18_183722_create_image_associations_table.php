<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageAssociationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('image_associations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('image_id')->unsigned()->index();
            $table->integer('imageable_id')->unsigned()->index();
            $table->string('imageable_type');
            $table->integer('image_category_id')->unsigned()->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('image_associations');
    }
}
