<?php

namespace Coeliac\Modules\EatingOut\WhereToEat\Listeners;

use Coeliac\Common\Models\TemporaryFileUpload;
use Coeliac\Modules\EatingOut\WhereToEat\Events\PrepareWhereToEatReviewImages;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Filesystem\FilesystemManager;
use Intervention\Image\Image;
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
            ->map(fn ($id) => TemporaryFileUpload::query()->findOrFail($id))
            ->each(function (TemporaryFileUpload $image) use ($event) {
                $rawFile = $this->filesystemManager->disk('uploads')->get($image->path);

                $this->persistImage($image, $rawFile);

                $this->persistThumbnail($image, $rawFile);

                $this->storeImageRow($event, $image);
            });
    }

    protected function persistImage(TemporaryFileUpload $image, ?string $rawFile): void
    {
        $this->filesystemManager
            ->disk('review-images')
            ->put($image->filename, $rawFile, 'public');
    }

    protected function createThumbnail(?string $rawFile): Image
    {
        return $this->imageManager
            ->make($rawFile)
            ->resize(250, 250, fn ($constraint) => $constraint->aspectRatio())
            ->encode(quality: 80);
    }

    protected function persistThumbnail(TemporaryFileUpload $image, ?string $rawFile): void
    {
        $this->filesystemManager
            ->disk('review-images')
            ->put('thumbs/' . $image->filename, $this->createThumbnail($rawFile), 'public');
    }

    protected function storeImageRow(PrepareWhereToEatReviewImages $event, TemporaryFileUpload $image): void
    {
        $event->review()->images()->create([
            'wheretoeat_id' => $event->review()->wheretoeat_id,
            'thumb' => 'thumbs/' . $image->filename,
            'path' => $image->path,
        ]);
    }
}
