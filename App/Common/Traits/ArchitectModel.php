<?php

declare(strict_types=1);

namespace Coeliac\Common\Traits;

use Illuminate\Support\Str;
use Coeliac\Base\Models\BaseModel;
use Illuminate\Container\Container;
use Intervention\Image\ImageManager;
use Coeliac\Common\Models\ImageAssociations;
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

    protected static function onSave(BaseModel $model)
    {
        if (!self::usesImages()) {
            return;
        }

        if (method_exists($model, 'images') && $model->images()->count() === 0) {
            return;
        }

        /** @var BlueprintSubmitRequest $request */
        $request = resolve(BlueprintSubmitRequest::class);

        /** @phpstan-ignore-next-line */
        $images = $model->fresh()->images()->get();
        $index = 0;
        $field = self::bodyField();
        $isDirty = false;
        $requestImages = json_decode($request->input('Images'));

        foreach ($requestImages->article as $image) {
            if (!Str::contains($model->$field, $image) || Str::contains($model->$field, '/'.$image)) {
                continue;
            }
            
            if(array_key_exists($index, $images)) {
                continue;
            }

            if ($image === $images[$index]->image->file_name) {
                ++$index;
                continue;
            }

            if (Str::contains($model->$field, $images[$index]->image->image_url)) {
                ++$index;
                continue;
            }

            $model->$field = Str::replaceFirst($image, $images[$index]->image->image_url, $model->$field);
            ++$index;

            $isDirty = true;
        }

        if ($isDirty) {
            $model->save();
        }
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
