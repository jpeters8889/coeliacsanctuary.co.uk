<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopProductAssignedTravelCardSearchTerms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_product_assigned_travel_card_search_terms', function (Blueprint $table) {
            $table->unsignedBigInteger('search_term_id');
            $table->unsignedInteger('product_id');
            $table->timestamps();

            $table->primary(['search_term_id', 'product_id'], 'joint_key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_product_assigned_travel_card_search_terms');
    }
}
