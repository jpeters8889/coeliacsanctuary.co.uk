<?php

namespace Coeliac\Modules\EatingOut\WhereToEat\Controllers;

use Carbon\Carbon;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Common\Models\TemporaryFileUpload;
use Coeliac\Modules\EatingOut\WhereToEat\Requests\WhereToEatReviewImageUploadRequest;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Http\UploadedFile;

class WhereToEatReviewImageUploadController extends BaseController
{
    public function __invoke(WhereToEatReviewImageUploadRequest $request, FilesystemManager $filesystem)
    {
        return [
            'images' => collect($request->file('images'))
                ->map(fn (UploadedFile $file) => ['file' => $file, 'path' => $file->store('/', 'uploads')])
                ->map(fn (array $upload) => [
                    ...$upload,
                    'row' => TemporaryFileUpload::createFromReviewImageUpload($upload['file'], $upload['path'])
                ])
                ->map(fn (array $upload) => [
                    'id' => $upload['row']->id,
                    'path' => $filesystem->disk('uploads')->temporaryUrl($upload['path'], Carbon::now()->addMinute()),
                ])
        ];
    }
}
