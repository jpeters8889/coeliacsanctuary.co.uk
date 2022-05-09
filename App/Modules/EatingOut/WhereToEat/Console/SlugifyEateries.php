<?php

namespace Coeliac\Modules\EatingOut\WhereToEat\Console;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Symfony\Component\Console\Helper\ProgressBar;

class SlugifyEateries extends Command
{
    protected $signature = 'coeliac:slugify-eateries {--dry}';

    protected ProgressBar $progressBar;

    public function handle(): void
    {
        if (!$this->option('dry') && !$this->confirm('Are you sure you want to slugify all eateries?')) {
            return;
        }

        $eateries = $this->getEateries();

        if (!$this->option('dry')) {
            $this->progressBar = $this->output->createProgressBar($eateries->count());
        }

        $eateries->each(function (WhereToEat $eatery) {
            $slug = $eatery->generateSlug();

            if (!$this->option('dry')) {
                $eatery->slug = $slug;

                $eatery->saveQuietly();

                $this->progressBar->advance();

                return;
            }

            $this->line("Setting slug of #{$eatery->id} - {$eatery->name} in {$eatery->town->town} to {$slug}");
        });
    }

    protected function getEateries(): array|Collection
    {
        return WhereToEat::query()
            ->where('live', 1)
            ->whereNull('slug')
            ->with(['country', 'county', 'town', 'features'])
            ->orderBy('country_id')
            ->orderBy('county_id')
            ->orderBy('town_id')
            ->get();
    }
}
