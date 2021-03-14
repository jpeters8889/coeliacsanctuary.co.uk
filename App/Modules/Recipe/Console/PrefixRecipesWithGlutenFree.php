<?php

declare(strict_types=1);

namespace Coeliac\Modules\Recipe\Console;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Coeliac\Modules\Recipe\Models\Recipe;

class PrefixRecipesWithGlutenFree extends Command
{
    protected $signature = 'coeliac:prefix-recipes {--prod}';

    public function handle()
    {
        if ($this->option('prod')) {
            if (!$this->confirm('This is set to run in production mode, are you sure?')) {
                return;
            }
        }

        $total = Recipe::query()->count();
        $skipped = 0;
        $updated = 0;

        Recipe::all()->each(function (Recipe $recipe) use (&$skipped, &$updated) {
            $this->info("Processing {$recipe->title}");

            if (Str::contains(Str::lower($recipe->title), 'gluten free')) {
                $this->error("{$recipe->title} already contains 'gluten free', skipping...");
                $this->next();
                ++$skipped;

                return;
            }

            $this->line('Setting the legacy slug');
            $recipe->legacy_slug = $recipe->slug;
            $this->info("Legacy slug for redirects is '{$recipe->legacy_slug}'");

            $this->line('Prefixing the title...');
            $recipe->title = "Gluten Free {$recipe->title}";
            $this->info("New title is '{$recipe->title}'");

            $this->line('updating the slug');
            $recipe->slug = Str::slug($recipe->title);
            $this->info("New slug is '{$recipe->slug}'");

            if ($this->option('prod')) {
                $this->warn('Committing changes to database');
                $recipe->saveQuietly();
            }

            ++$updated;
            $this->next();
        });

        $this->table([], [
            ['Total Recipes', $total],
            ['Recipes Updated', $updated],
            ['Recipes Skipped', $skipped],
        ]);
    }

    protected function next(): void
    {
        $this->line('--------');
    }
}
