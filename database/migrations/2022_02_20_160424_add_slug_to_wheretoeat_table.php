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
        Schema::table('wheretoeat', function (Blueprint $table) {
            $table->string('slug', 255)->after('name')->nullable()->default(null);

            $table->index(['slug', 'town_id'], 'town_slug_index');
        });
    }
};
