<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;

class PopulateDailyUpdatesTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Coeliac\Modules\Member\Models\DailyUpdateType::query()->insert([
            [
                'name' => 'Blog Tags',
                'description' => 'Get notifications whenever we add a new blog with tags that you\'re subscribed to.',
                'updatable_type' => \Coeliac\Modules\Blog\Models\BlogTag::class,
            ],
            [
                'name' => 'Where To Eat - County',
                'description' => 'Get notifications whenever a new place to eat is added to this county.',
                'updatable_type' => \Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty::class,
            ],
            [
                'name' => 'Where To Eat - Town',
                'description' => 'Get notifications whenever a new place to eat is added to this town.',
                'updatable_type' => \Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatTown::class,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Illuminate\Support\Facades\DB::table('daily_update_types')->truncate();
    }
}
