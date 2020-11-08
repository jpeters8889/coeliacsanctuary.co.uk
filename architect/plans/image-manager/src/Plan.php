<?php

declare(strict_types=1);

namespace Coeliac\Architect\Plans\ImageManager;

use Illuminate\Http\File;
use Illuminate\Support\Str;
use Coeliac\Common\Models\Image;
use Illuminate\Support\Collection;
use Coeliac\Common\Traits\Imageable;
use Intervention\Image\ImageManager;
use Illuminate\Database\Eloquent\Model;
use Coeliac\Common\Models\ImageAssociations;
use Illuminate\Filesystem\FilesystemManager;
use JPeters\Architect\Plans\Plan as ArchitectPlan;

class Plan extends ArchitectPlan
{
    private $socialImage = true;
    private $mainImage = true;
    private $squareImage = true;
    private $insertImage = false;
    private $insertIntoField;
    private $uploadDirectoryOverride;
    private $uploadDirectoryColumn = 'slug';
    private $uploadCategory = Image::IMAGE_CATEGORY_GENERAL;

    public bool $deferUpdate = true;

    public static function generate(...$args): self
    {
        return new self(...$args);
    }

    public function vuePrefix(): string
    {
        return 'image-manager';
    }

    public function getCurrentValue(Model $model)
    {
        /** @var Imageable $model */
        /** @var ImageManager $imageManager */
        $imageManager = resolve(ImageManager::class);

        return $model->images->transform(static function (ImageAssociations $imageAssociation) use ($imageManager) {
            $fileName = $imageAssociation->image->file_name;
            $category = $imageAssociation->category->category;

            $url = config('architect.upload_directory').'/'.$fileName;

            $image = $imageManager
                ->make($imageAssociation->image->image_url)
                ->save(public_path($url));

            return [
                'path' => $url,
                'filename' => $fileName,
                'type' => $category !== 'general' ? $category : 'article',
                'width' => $image->width(),
                'height' => $image->height(),
            ];
        });
    }

    public function handleUpdate(Model $model, $column, $value)
    {
        /* @var Imageable $model */
        $model->images->each(static function(ImageAssociations $imageAssociation) {
            $imageAssociation->image->delete();
            $imageAssociation->delete();
        });

        (new Collection(json_decode($value, true)))
            ->each(function ($image, $method) use ($model) {
                switch ($method) {
                    case 'social':
                        $category = Image::IMAGE_CATEGORY_SOCIAL;
                        break;
                    case 'header':
                        $category = Image::IMAGE_CATEGORY_HEADER;
                        break;
                    case 'square':
                        $category = Image::IMAGE_CATEGORY_SQUARE;
                        break;
                    default:
                        if (!is_array($image)) {
                            $image = [$image];
                        }

                        foreach ($image as $img) {
                            $this->processImage($img, $model);
                        }

                        return;
                }

                $this->processImage($image, $model, $category);
            });
    }

    private function getRootDirectory(Model $model): string
    {
        if ($this->uploadDirectoryOverride) {
            return $this->uploadDirectoryOverride;
        }

        return (string) Str::of(class_basename($model))
            ->plural()
            ->slug();
    }

    private function getImageSaveDirectory(Model $model)
    {
        return $model->{$this->uploadDirectoryColumn};
    }

    private function processImage($image, Model $model, $imageCategory = Image::IMAGE_CATEGORY_GENERAL)
    {
        /** @var FilesystemManager $filesystem */
        $filesystem = app(FilesystemManager::class);

        $imagePath = public_path(config('architect.upload_directory').'/'.$image);

        $directory = $this->getRootDirectory($model).'/'.$this->getImageSaveDirectory($model);

        $uploadedImageName = last(explode('/', $filesystem->disk('images')
            ->putFile($directory, new File($imagePath), 'public')));

        /* @var Imageable $model */
        $model->associateImage(Image::query()->create([
            'file_name' => $uploadedImageName,
            'directory' => $directory,
        ]), $imageCategory);
    }

    public function disableSquareImageOption()
    {
        $this->squareImage = false;

        return $this;
    }

    public function disableMainImageOption()
    {
        $this->mainImage = false;

        return $this;
    }

    public function disableSocialImageOption()
    {
        $this->socialImage = false;

        return $this;
    }

    public function enableImageInserts($intoField)
    {
        $this->insertImage = true;
        $this->insertIntoField = $intoField;

        return $this;
    }

    public function getMetas(): array
    {
        return array_merge(parent::getMetas() ?? [], [
            'buttons' => [
                'social' => $this->socialImage,
                'header' => $this->mainImage,
                'square' => $this->squareImage,
                'insert' => $this->insertImage,
            ],
            'insertImageIntoField' => $this->insertIntoField,
        ]);
    }

    public function setImageDirectory($directory)
    {
        $this->uploadDirectoryOverride = $directory;

        return $this;
    }

    public function setUploadDirectoryColumn($column)
    {
        $this->uploadDirectoryColumn = $column;

        return $this;
    }

    public function setDefaultImageCategory($category)
    {
        $this->uploadCategory = $category;

        return $this;
    }
}
