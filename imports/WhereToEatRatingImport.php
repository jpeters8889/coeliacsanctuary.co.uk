<?php

declare(strict_types=1);

namespace Imports;

use Illuminate\Database\Eloquent\Builder;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;

class WhereToEatRatingImport extends Import
{
    public function handle()
    {
        $seeds = $this->seedDatabase->table('wheretoeat_ratings')->get();

        $bar = $this->command->makeProgressBar(count($seeds));
        $bar->start();

        foreach ($seeds as $seed) {
            $oldWte = $this->seedDatabase->table('wheretoeat')->where('id', $seed->wteID)->first();

            if (!$oldWte) {
                continue;
            }

            /** @var WhereToEat $wte */
            $wte = WhereToEat::query()
                ->where('name', $oldWte->name)
                ->whereHas('town', function (Builder $builder) use ($oldWte) {
                    return $builder->where('legacy', $oldWte->town);
                })
                ->firstOrFail();

            $wte->ratings()
                ->create([
                    'rating' => (int) $seed->rating,
                    'ip' => $seed->ip,
                    'name' => $seed->name,
                    'email' => $seed->email,
                    'body' => $seed->body,
                    'method' => $seed->method,
                    'approved' => $seed->approved,
                    'created_at' => $seed->created_at,
                    'updated_at' => $seed->updated_at,
                ]);

            $bar->advance();
        }

        $bar->finish();
    }
}
