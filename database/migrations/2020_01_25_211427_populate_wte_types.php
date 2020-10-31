<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatType;

class PopulateWteTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        WhereToEatType::query()->insert([
            ['type' => 'wte', 'name' => 'Eatery'],
            ['type' => 'att', 'name' => 'Attraction'],
            ['type' => 'hotel', 'name' => 'Hotel / B&B'],
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
