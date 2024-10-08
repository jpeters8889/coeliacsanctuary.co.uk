<?php

declare(strict_types=1);

namespace Coeliac\Base\Console\Commands;

use Carbon\Carbon;
use Coeliac\Common\Models\TemporaryFileUpload;
use Illuminate\Console\Command;
use Illuminate\Filesystem\FilesystemManager;

class CleanUpFileUploads extends Command
{
    protected $signature = 'coeliac:clean_file_uploads';

    public function handle(FilesystemManager $filesystem): void
    {
        TemporaryFileUpload::query()
            ->where('delete_at', '<', Carbon::now()->toDateTimeString())
            ->get()
            ->each(function (TemporaryFileUpload $fileUpload) use ($filesystem) {
                $filesystem->disk('uploads')->delete($fileUpload->path);

                $fileUpload->delete();
            });
    }
}
