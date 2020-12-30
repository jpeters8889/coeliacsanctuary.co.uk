<?php

declare(strict_types=1);

namespace Coeliac\Common\Traits;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Coeliac\Base\Models\BaseModel;
use Illuminate\Container\Container;
use Intervention\Image\ImageManager;
use Coeliac\Common\Models\ImageAssociations;
use Illuminate\Cache\Repository as CacheRepository;
use JPeters\Architect\Http\Requests\BlueprintSubmitRequest;

/**
 * @mixin BaseModel
 */
trait ArchitectModel
{
    public static function bootArchitectModel()
    {
        static::creating(static function (BaseModel $model) {
            self::onCreate($model);
        });

        static::saved(static function (BaseModel $model) {
            self::onSave($model);
        });
    }

    protected static function resolveTitleField(BaseModel $model)
    {
        if (is_array(self::titleField())) {
            $titles = [];

            foreach (self::titleField() as $field) {
                $titles[] = data_get($field, $model->toArray());
            }

            return implode(' ', $titles);
        }

        return $model->{self::titleField()};
    }

    protected static function onCreate(BaseModel $model)
    {
        if (!$model->{self::slugField()}) {
            $model->{self::slugField()} = Str::slug(self::resolveTitleField($model));
        }
    }

    protected static function requiresImageProcessing($model): bool
    {
        if (!self::usesImages()) {
            return false;
        }

        if (method_exists($model, 'images') && $model->images()->count() === 0) {
            return false;
        }

        if (Container::getInstance()->make(CacheRepository::class)->has(self::imageCacheKey($model))) {
            return false;
        }

        if ($model->images()->first()->created_at->lt($model->updated_at)) {
            return false;
        }

        return true;
    }

    protected static function onSave(BaseModel $model)
    {
        if (!self::requiresImageProcessing($model)) {
            return;
        }

        /** @var BlueprintSubmitRequest $request */
        $request = resolve(BlueprintSubmitRequest::class);

        /** @phpstan-ignore-next-line */
        $images = $model->fresh()->images()->get();
        $index = 0;
        $field = self::bodyField();
        $requestImages = json_decode($request->input('Images'));

        foreach ($requestImages->article as $image) {
            $model->$field = Str::replaceFirst($image, $images[$index]->image->image_url, $model->$field);
            ++$index;
        }

        if ($model->isDirty()) {
            Container::getInstance()
                ->make(CacheRepository::class)
                ->put(self::imageCacheKey($model), true, Carbon::now()->addSeconds(10));

            $model->save();
        }
    }

    /**
     * @param BaseModel $model
     *
     * @return string
     */
    protected static function imageCacheKey(BaseModel $model): string
    {
        return "{$model->getTable()}-{$model->id}-images-saved";
    }

    public function getArchitectBodyAttribute()
    {
        $current = $this->{self::bodyField()};

        $current = cs_br2nl($current);

        if (self::usesImages()) {
            $imageManager = Container::getInstance()->make(ImageManager::class);
            $uploadDirectory = config('architect.upload_directory');

            foreach ($this->images()->get() as $image) {
                /* @var ImageAssociations $image */
                $imageManager->make($image->image->image_url)
                    ->save(public_path("{$uploadDirectory}/{$image->image->file_name}"));

                $current = str_replace(
                    $image->image->image_url,
                    $image->image->file_name,
                    $current
                );
            }
        }

        return $current;
    }

    public function setArchitectBodyAttribute($value)
    {
        $value = cs_nl2br($value);

        $this->{self::bodyField()} = $value;
    }

    protected static function bodyField(): string
    {
        return 'body';
    }

    protected static function slugField(): string
    {
        return 'slug';
    }

    /**
     * @return string|array<string>
     */
    protected static function titleField()
    {
        return 'title';
    }

    protected static function usesImages(): bool
    {
        return false;
    }
}
