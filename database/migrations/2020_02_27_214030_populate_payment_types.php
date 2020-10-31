<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;

class PopulatePaymentTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::table('shop_payment_types')->insert([
            ['type' => 'Stripe'],
            ['type' => 'PayPal'],
            ['type' => 'Etsy'],
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
