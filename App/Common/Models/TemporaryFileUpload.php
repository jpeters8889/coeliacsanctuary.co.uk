<?php

namespace Coeliac\Common\Models;

use Carbon\Carbon;
use Coeliac\Base\Models\BaseModel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

/**
 * @property string $filename
 * @property string $path
 */
class TemporaryFileUpload extends BaseModel
{
    protected $dates = ['delete_at'];

    public $incrementing = false;

    protected $keyType = 'string';

    protected static function booted()
    {
        self::creating(function (self $model) {
            $model->id ??= Str::uuid()->toString();

            return $model;
        });
    }

    public static function createFrom(UploadedFile $file, string $path, string $source = 'upload', Carbon $deleteAt = null): self
    {
        $deleteAt ??= Carbon::now()->addDay();

        return static::query()->create([
            'filename' => $file->hashName(),
            'path' => $path,
            'source' => $source,
            'filesize' => $file->getSize(),
            'mime' => $file->getMimeType(),
            'delete_at' => $deleteAt,
        ]);
    }

    public static function createFromReviewImageUpload(UploadedFile $file, string $path): self
    {
        return static::createFrom($file, $path, 'wte-review-image', Carbon::now()->addMinutes(15));
    }
}
