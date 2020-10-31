<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('image_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category', 50);
            $table->timestamps();
        });

        \Illuminate\Support\Facades\DB::table('image_categories')->insert([
            ['category' => 'general'],
            ['category' => 'header'],
            ['category' => 'social'],
            ['category' => 'square'],
            ['category' => 'hero'],
            ['category' => 'popup'],
            ['category' => 'shop_category'],
            ['category' => 'shop_product'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('image_categories');
    }
}
