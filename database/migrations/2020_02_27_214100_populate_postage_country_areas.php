<?php

declare(strict_types=1);

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class PopulatePostageCountryAreas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('shop_postage_country_areas')->insert(['area' => 'United Kingdom', 'delivery_timescale' => '1 - 2', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('shop_postage_country_areas')->insert(['area' => 'Europe', 'delivery_timescale' => '3 - 4', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('shop_postage_country_areas')->insert(['area' => 'North America', 'delivery_timescale' => '5 - 7', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('shop_postage_country_areas')->insert(['area' => 'Oceana', 'delivery_timescale' => '5 - 7', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
