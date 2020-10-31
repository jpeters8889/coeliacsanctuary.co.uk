<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;

class PopulateOrderStates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::table('shop_order_states')->insert([
            ['state' => 'Basket'],
            ['state' => 'Order'],
            ['state' => 'Processing'],
            ['state' => 'Shipped'],
            ['state' => 'Complete'],
            ['state' => 'Refund'],
            ['state' => 'Cancelled'],
            ['state' => 'Expired'],
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
