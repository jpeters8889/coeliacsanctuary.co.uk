<?php

declare(strict_types=1);

namespace Coeliac\Common\FeaturedImages;

use Coeliac\Common\Models\Image;
use JPeters\Architect\Plans\Boolean;
use JPeters\Architect\Plans\Ordering;
use JPeters\Architect\Plans\Textarea;
use JPeters\Architect\Plans\Textfield;
use Coeliac\Common\Models\FeaturedImage;
use JPeters\Architect\Blueprints\Blueprint;
use Coeliac\Architect\Plans\ImageManager\Plan;

class FeaturedImagesBlueprint extends Blueprint
{
    public function model(): string
    {
        return FeaturedImage::class;
    }

    public function blueprintName(): string
    {
        return 'Featured Images';
    }

    public function ordering(): array
    {
        return ['order', 'asc'];
    }

    public function plans(): array
    {
        return [
            Ordering::generate('order')->hideOnForms(),

            Plan::generate('Image')
                ->setImageDirectory('heros')
                ->setUploadDirectoryColumn('id')
                ->setDefaultImageCategory(Image::IMAGE_CATEGORY_HERO)
                ->hideOnIndex(),

            Textfield::generate('title'),

            Textarea::generate('description'),

            Textfield::generate('link'),

            Boolean::generate('active'),
        ];
    }

    public function searchable(): bool
    {
        return false;
    }
}
