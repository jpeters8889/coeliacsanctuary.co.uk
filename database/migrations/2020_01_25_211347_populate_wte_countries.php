<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCountry;

class PopulateWteCountries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        WhereToEatCountry::query()->insert([
            ['country' => 'Nationwide'],
            ['country' => 'Channel Islands'],
            ['country' => 'England'],
            ['country' => 'Isle of Man'],
            ['country' => 'Northern Ireland'],
            ['country' => 'Republic of Ireland'],
            ['country' => 'Scotland'],
            ['country' => 'Wales'],
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
