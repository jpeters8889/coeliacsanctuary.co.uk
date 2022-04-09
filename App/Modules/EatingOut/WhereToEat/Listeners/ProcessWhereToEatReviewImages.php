<?php

namespace Coeliac\Modules\EatingOut\WhereToEat\Listeners;

use Coeliac\Common\Models\TemporaryFileUpload;
use Coeliac\Modules\EatingOut\WhereToEat\Events\PrepareWhereToEatReviewImages;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Filesystem\FilesystemManager;
use Intervention\Image\ImageManager;

class ProcessWhereToEatReviewImages implements ShouldQueue
{
    public function __construct(protected FilesystemManager $filesystemManager, protected ImageManager $imageManager)
    {
        //
    }

    public function handle(PrepareWhereToEatReviewImages $event)
    {
        $event->images()
            ->map(fn($id) => TemporaryFileUpload::query()->findOrFail($id))
            ->each(function (TemporaryFileUpload $image) use ($event) {
                $rawFile = $this->filesystemManager->disk('uploads')->get($image->path);

                $this->filesystemManager
                    ->disk('review-images')
                    ->put($image->filename, $rawFile);

                $thumbnail = $this->imageManager
                    ->make($rawFile)
                    ->resize(250, null, fn($constraint) => $constraint->aspectRatio())
                    ->encode(quality: 80);

                $this->filesystemManager
                    ->disk('review-images')
                    ->put('thumbs/' . $image->filename, $thumbnail);

                $event->review()->images()->create([
                    'wheretoeat_id' => $event->review()->wheretoeat_id,
                    'thumb' => '',
                    'path' => $image->path,
                ]);
            });
    }
}
