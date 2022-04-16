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
        Schema::table('wheretoeat_reviews', function (Blueprint $table) {
            $table->string('branch_name')->after('service_rating')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wheretoeat_reviews', function (Blueprint $table) {
            $table->dropColumn('branch_name');
        });
    }
};
