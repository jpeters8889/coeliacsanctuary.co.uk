<?php

declare(strict_types=1);

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class PopulateShippingMethods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('shop_shipping_methods')->insert(['shipping_method' => 'small-letter', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('shop_shipping_methods')->insert(['shipping_method' => 'letter', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('shop_shipping_methods')->insert(['shipping_method' => 'large-letter', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('shop_shipping_methods')->insert(['shipping_method' => 'small-parcel', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('shop_shipping_methods')->insert(['shipping_method' => 'parcel', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        DB::table('shop_shipping_methods')->insert(['shipping_method' => 'large-parcel', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
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
