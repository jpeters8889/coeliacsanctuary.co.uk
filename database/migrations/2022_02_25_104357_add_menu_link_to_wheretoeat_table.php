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
        Schema::table('wheretoeat', function (Blueprint $table) {
            $table->string('gf_menu_link', 255)->nullable()->after('website')->default(null);
        });
    }
};
