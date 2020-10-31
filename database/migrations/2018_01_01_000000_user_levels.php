<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserLevels extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('user_levels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->timestamps();
        });

        \Illuminate\Support\Facades\DB::table('user_levels')->insert([
            ['description' => 'Shop Purchaser'],
            ['description' => 'Member'],
            ['description' => 'Admin'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('user_levels');
    }
}
