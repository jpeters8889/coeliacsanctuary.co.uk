<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatFeature;

class PopulateWteFeatures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        WhereToEatFeature::query()->insert([
            ['feature' => '100% Gluten Free', 'icon' => 'fullGF', 'type_id' => 1],
            ['feature' => 'Afternoon Tea', 'icon' => 'aftTea', 'type_id' => 1],
            ['feature' => 'Chinese', 'icon' => 'chinese', 'type_id' => 1],
            ['feature' => 'Fish and Chips', 'icon' => 'FnC', 'type_id' => 1],
            ['feature' => 'Gluten Free Menu', 'icon' => 'gfMenu', 'type_id' => 1],
            ['feature' => 'Pizza', 'icon' => 'pizza', 'type_id' => 1],
            ['feature' => 'Pub Grub', 'icon' => 'pubGrub', 'type_id' => 1],
            ['feature' => 'Vegan', 'icon' => 'vegan', 'type_id' => 1],
            ['feature' => 'Wifi', 'icon' => 'wifi', 'type_id' => 3],
            ['feature' => 'Gym', 'icon' => 'gym', 'type_id' => 3],
            ['feature' => 'Parking', 'icon' => 'parking', 'type_id' => 3],
            ['feature' => 'Spa', 'icon' => 'spa', 'type_id' => 3],
            ['feature' => 'Pool', 'icon' => 'pool', 'type_id' => 3],
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
