<?php

declare(strict_types=1);

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class PopulatePostageCountries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('shop_postage_countries')->insert([
            'postage_area_id' => '1',
            'country' => 'United Kingdom',
            'iso_code' => 'GB',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('shop_postage_countries')->insert([
            'postage_area_id' => '2',
            'country' => 'Republic of Ireland',
            'iso_code' => 'IE',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('shop_postage_countries')->insert([
            'postage_area_id' => '2',
            'country' => 'Denmark',
            'iso_code' => 'DK',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('shop_postage_countries')->insert([
            'postage_area_id' => '2',
            'country' => 'Norway',
            'iso_code' => 'NO',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('shop_postage_countries')->insert([
            'postage_area_id' => '2',
            'country' => 'Sweden',
            'iso_code' => 'SE',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('shop_postage_countries')->insert([
            'postage_area_id' => '2',
            'country' => 'France',
            'iso_code' => 'FE',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('shop_postage_countries')->insert([
            'postage_area_id' => '2',
            'country' => 'Germany',
            'iso_code' => 'DE',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('shop_postage_countries')->insert([
            'postage_area_id' => '2',
            'country' => 'Italy',
            'iso_code' => 'IT',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('shop_postage_countries')->insert([
            'postage_area_id' => '2',
            'country' => 'Netherlands',
            'iso_code' => 'NL',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('shop_postage_countries')->insert([
            'postage_area_id' => '2',
            'country' => 'Portugal',
            'iso_code' => 'PT',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('shop_postage_countries')->insert([
            'postage_area_id' => '2',
            'country' => 'Spain',
            'iso_code' => 'ES',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('shop_postage_countries')->insert([
            'postage_area_id' => '2',
            'country' => 'Finland',
            'iso_code' => 'FI',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('shop_postage_countries')->insert([
            'postage_area_id' => '2',
            'country' => 'Belgium',
            'iso_code' => 'BE',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('shop_postage_countries')->insert([
            'postage_area_id' => '2',
            'country' => 'Greenland',
            'iso_code' => 'GL',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('shop_postage_countries')->insert([
            'postage_area_id' => '2',
            'country' => 'Iceland',
            'iso_code' => 'IS',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('shop_postage_countries')->insert([
            'postage_area_id' => '2',
            'country' => 'Greece',
            'iso_code' => 'GR',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('shop_postage_countries')->insert([
            'postage_area_id' => '2',
            'country' => 'Malta',
            'iso_code' => 'MT',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('shop_postage_countries')->insert([
            'postage_area_id' => '3',
            'country' => 'United States',
            'iso_code' => 'US',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('shop_postage_countries')->insert([
            'postage_area_id' => '3',
            'country' => 'Canada',
            'iso_code' => 'CA',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('shop_postage_countries')->insert([
            'postage_area_id' => '4',
            'country' => 'Australia',
            'iso_code' => 'AU',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('shop_postage_countries')->insert([
            'postage_area_id' => '4',
            'country' => 'New Zealand',
            'iso_code' => 'NZ',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
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
