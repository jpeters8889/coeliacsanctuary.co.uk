<?php

declare(strict_types=1);

namespace Coeliac\Modules\Collection\Architect;

use Coeliac\Architect\Plans\CollectionItems\Plan as CollectionItemsPlan;
use Coeliac\Architect\Plans\ImageManager\Plan as ImageManagerPlan;
use Coeliac\Modules\Collection\Models\Collection;
use Illuminate\Database\Eloquent\Builder;
use JPeters\Architect\Blueprints\Blueprint as ArchitectBlueprint;
use JPeters\Architect\Plans\Body;
use JPeters\Architect\Plans\DateTime;
use JPeters\Architect\Plans\Label;
use JPeters\Architect\Plans\Textarea;
use JPeters\Architect\Plans\Textfield;

class Blueprint extends ArchitectBlueprint
{
    public function model(): string
    {
        return Collection::class;
    }

    public function getData(): Builder
    {
        return parent::getData()->with(['images'])->withCount('items');
    }

    public function plans(): array
    {
        return [
            Textfield::generate('title'),

            Textfield::generate('meta_keywords')->hideOnIndex(),

            Textarea::generate('meta_description'),

            Textarea::generate('long_description')->rows(4)->hideOnIndex(),

            ImageManagerPlan::generate('Image')
                ->disableSquareImageOption()
                ->setImageDirectory('collections')
                ->hideOnIndex(),

            Body::generate('architect_body', 'Page Text')->hideOnIndex(),

            CollectionItemsPlan::generate('Items')->hideOnIndex(),

            Label::generate('items_count', 'Items')->hideOnForms(),

            DateTime::generate('created_at')->hideOnForms(),
        ];
    }
}
