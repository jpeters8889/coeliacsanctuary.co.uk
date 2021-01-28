<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSearchHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::table('search_history')->truncate();

        Schema::table('search_history', function (Blueprint $table) {
            $table->unsignedBigInteger('number_of_searches')->default(0)->after('term');

            $table->unique('term');
        });

        Schema::table('search_history', function (Blueprint $table) {
            $table->dropColumn(['blogs', 'recipes', 'reviews', 'eateries', 'products']);
        });
    }
}
