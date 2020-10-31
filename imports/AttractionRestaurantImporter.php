<?php

declare(strict_types=1);

namespace Imports;

use Illuminate\Database\Eloquent\Builder;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;

class AttractionRestaurantImporter extends Import
{
    public function handle()
    {
        $seeds = $this->seedDatabase->table('att_rests')->get();

        $bar = $this->command->makeProgressBar(count($seeds));
        $bar->start();

        foreach ($seeds as $seed) {
            $oldWte = $this->seedDatabase->table('wheretoeat')->where('id', $seed->attID)->first();

            if (!$oldWte) {
                continue;
            }

            WhereToEat::query()
                ->where('name', $oldWte->name)
                ->whereHas('town', function (Builder $builder) use ($oldWte) {
                    return $builder->where('legacy', $oldWte->town);
                })
                ->firstOrFail()
                ->restaurants()
                ->create([
                    'restaurant_name' => $seed->restName,
                    'info' => $seed->info,
                    'created_at' => $seed->created_at,
                    'updated_at' => $seed->updated_at,
                ]);

            $bar->advance();
        }

        $bar->finish();
    }
}
