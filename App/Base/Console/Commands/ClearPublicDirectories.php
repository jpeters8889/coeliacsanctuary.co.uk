<?php

declare(strict_types=1);

namespace Coeliac\Base\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Finder\SplFileInfo;

class ClearPublicDirectories extends Command
{
    protected $signature = 'coeliac:clear_public_dirs';

    public function handle(Filesystem $filesystem)
    {
        $files = $filesystem->allFiles(public_path('cs-adm-uploads'));

        $bar = $this->getOutput()->createProgressBar(count($files));

        (new Collection($files))
            ->map(static function (SplFileInfo $file) use ($filesystem, $bar) {
                $filesystem->delete($file->getRealPath());
                $bar->advance();
            });
    }
}
