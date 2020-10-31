<?php

declare(strict_types=1);

namespace Imports;

use Coeliac\Modules\EatingOut\WhereToEat\Models\PlaceRequest;

class PlaceRequestImport extends Import
{
    public function handle()
    {
        $seeds = $this->seedDatabase->table('place-requests')->get();

        $bar = $this->command->makeProgressBar(count($seeds));
        $bar->start();

        foreach ($seeds as $seed) {
            PlaceRequest::query()->create([
                'name' => $seed->name,
                'addOrRemove' => $seed->addOrRemove,
                'details' => $seed->details,
                'completed' => $seed->completed,
                'created_at' => $seed->created_at,
                'updated_at' => $seed->updated_at,
            ]);

            $bar->advance();
        }

        $bar->finish();
    }
}
