<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopMassDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_mass_discounts', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->unsignedTinyInteger('percentage');
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->boolean('created')->default(false);
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
        Schema::dropIfExists('shop_mass_discounts');
    }
}
