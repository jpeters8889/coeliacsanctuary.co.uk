<?php

declare(strict_types=1);

namespace Coeliac\Modules\Blog\Architect;

use JPeters\Architect\Plans\Body;
use JPeters\Architect\Plans\Boolean;
use Coeliac\Modules\Blog\Models\Blog;
use JPeters\Architect\Plans\DateTime;
use JPeters\Architect\Plans\Textarea;
use JPeters\Architect\Plans\Textfield;
use Illuminate\Database\Eloquent\Builder;
use Coeliac\Architect\Plans\TagManager\Plan as TagManager;
use Coeliac\Architect\Plans\ImageManager\Plan as ImageManager;
use JPeters\Architect\Blueprints\Blueprint as ArchitectBlueprint;

class Blueprint extends ArchitectBlueprint
{
    public function model(): string
    {
        return Blog::class;
    }

    public function plans(): array
    {
        return [
            Textfield::generate('title'),

            TagManager::generate('blog_tags', 'Tags')
                ->hideOnIndex()
                ->useTagSource('blogTags'),

            Textfield::generate('meta_tags')
                ->hideOnIndex(),

            Textarea::generate('meta_description')
                ->rows(2)
                ->hideFromIndexOnMobile(),

            Textarea::generate('description')
                ->hideOnIndex(),

            Boolean::generate('live', 'Published'),

            ImageManager::generate('Images')
                ->disableSquareImageOption()
                ->enableImageInserts('architect_body')
                ->hideOnIndex(),

            Body::generate('architect_body', 'Body')
                ->hideOnIndex(),

            DateTime::generate('created_at')
                ->hideOnForms(),
        ];
    }

    public function filters(): array
    {
        return [
            'live' => [
                'name' => 'Published',
                'options' => [
                    1 => 'Yes',
                    0 => 'No',
                ],
                'filter' => fn (Builder $builder, $value) => $builder->where('live', $value),
            ],
        ];
    }
}
