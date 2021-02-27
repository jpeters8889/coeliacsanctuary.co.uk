<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;

class PopulateUserSubscriptionTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Coeliac\Modules\Member\Models\SubscriptionType::query()->insert([
            [
                'name' => 'Blog Tags',
                'description' => '...',
                'subscribable_type' => \Coeliac\Modules\Blog\Models\BlogTag::class,
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
        \Illuminate\Support\Facades\DB::table('user_subscription_types')->truncate();
    }
}
