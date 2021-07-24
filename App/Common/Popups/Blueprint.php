<?php

declare(strict_types=1);

namespace Coeliac\Common\Popups;

use Coeliac\Common\Models\Image;
use Coeliac\Common\Models\Popup;
use JPeters\Architect\Plans\Boolean;
use JPeters\Architect\Plans\DateTime;
use JPeters\Architect\Plans\Textarea;
use JPeters\Architect\Plans\Textfield;
use Coeliac\Architect\Plans\ImageManager\Plan;
use JPeters\Architect\Blueprints\Blueprint as ArchitectBlueprint;

class Blueprint extends ArchitectBlueprint
{
    public function model(): string
    {
        return Popup::class;
    }

    public function blueprintSite(): string
    {
        return 'Site';
    }

    public function makeVisible(): array
    {
        return ['live', 'display_every'];
    }

    public function plans(): array
    {
        return [
            Plan::generate('Image')
                ->setImageDirectory('popups')
                ->setUploadDirectoryColumn('id')
                ->setDefaultImageCategory(Image::IMAGE_CATEGORY_HERO)
                ->hideOnIndex(),

            Textarea::generate('text')->hideFromIndexOnMobile(),

            Textfield::generate('link'),

            Textfield::generate('display_every'),

            Boolean::generate('live'),

            DateTime::generate('created_at')->hideOnForms(),
        ];
    }

    public function searchable(): bool
    {
        return false;
    }
}
