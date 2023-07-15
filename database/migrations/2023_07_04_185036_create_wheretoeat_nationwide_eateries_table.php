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
        Schema::create('wheretoeat_nationwide_branches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wheretoeat_id');
            $table->string('name')->nullable();
            $table->unsignedInteger('country_id')->index();
            $table->unsignedInteger('county_id')->index();
            $table->unsignedInteger('town_id')->index();
            $table->text('address');
            $table->string('lat', 50);
            $table->string('lng', 50);
            $table->boolean('live');
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
        Schema::dropIfExists('wheretoeat_nationwide_branches');
    }
};
