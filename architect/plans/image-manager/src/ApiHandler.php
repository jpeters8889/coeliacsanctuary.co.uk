<?php

declare(strict_types=1);

namespace Coeliac\Architect\Plans\ImageManager;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Intervention\Image\ImageManager;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ApiHandler
{
    public function upload(ImageManager $imageManager, Request $request)
    {
        try {
            $uploadDirectory = config('architect.upload_directory');

            return (new Collection($request->files->all()['files']))
                ->transform(static function (UploadedFile $file) use ($imageManager, $uploadDirectory) {
                    $filename = $file->getClientOriginalName();
                    $url = "{$uploadDirectory}/{$filename}";

                    $image = $imageManager->make($file->getRealPath())
                        ->save(public_path($url));

                    return [
                        'path' => $url,
                        'filename' => $filename,
                        'width' => $image->width(),
                        'height' => $image->height(),
                    ];
                })
                ->values();
        } catch (Throwable $exception) {
            Bugsnag::notifyException($exception);
            abort(500, 'There was an error uploading the images');
        }
    }
}
