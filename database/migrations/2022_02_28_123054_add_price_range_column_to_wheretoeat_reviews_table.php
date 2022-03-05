<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wheretoeat_reviews', function (Blueprint $table) {
            $table->enum('price_range', [1,2,3,4,5])->after('email')->nullable()->default(null);
        });
    }
};
