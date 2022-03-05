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
            $slug = Str::of($eatery->name)
                ->when(
                    $this->hasDuplicateNameInTown($eatery),
                    fn(Stringable $str) => $str->append(' ' . $this->eateryPostcode($eatery)),
                )
                ->slug()
                ->toString();

            if (!$this->option('dry')) {
                $eatery->slug = $slug;

                $eatery->saveQuietly();

                $this->progressBar->advance();

                return;
            }

            $this->line("Setting slug of #{$eatery->id} - {$eatery->name} in {$eatery->town->town} to {$slug}");
        });
    }

    protected function eateryPostcode(WhereToEat $eatery): string
    {
        $address = explode('<br />', $eatery->address);

        return array_pop($address);
    }

    protected function hasDuplicateNameInTown(WhereToEat $eatery): bool
    {
        return WhereToEat::query()
                ->where('town_id', $eatery->town_id)
                ->where('name', $eatery->name)
                ->where('live', 1)
                ->count() > 1;
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
