<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopMassDiscountCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_mass_discount_categories', function (Blueprint $table) {
            $table->foreignId('mass_discount_id');
            $table->foreignId('category_id');
            $table->timestamps();

            $table->primary(['mass_discount_id', 'category_id'], 'category_discount_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_mass_discount_categories');
    }
}
