<?php

declare(strict_types=1);

use Illuminate\Database\Seeder;

class PlaceRequestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeds = DB::connection('seed')->table('place-requests')->get();

        foreach ($seeds as $seed) {
            DB::connection('mysql')->table('place_requests')->insert([
                'name' => $seed->name,
                'addOrRemove' => $seed->addOrRemove,
                'details' => $seed->details,
                'completed' => $seed->completed,
                'created_at' => $seed->created_at,
                'updated_at' => $seed->updated_at,
            ]);
        }
    }
}
