<?php

declare(strict_types=1);

use Coeliac\Common\Models\User;
use Illuminate\Database\Migrations\Migration;

class PopulateUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (app()->runningUnitTests()) {
            return;
        }

        User::query()->insert([
            [
                'name' => 'Jamie',
                'email' => 'jamie@jamie-peters.co.uk',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
                'user_level_id' => 3,
            ],
            [
                'name' => 'Ally',
                'email' => 'contact@coeliacsanctuary.co.uk',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
                'user_level_id' => 3,
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
        //
    }
}
