<?php

declare(strict_types=1);

namespace Coeliac\Modules\Collection\Items;

use Coeliac\Modules\Blog\Models\Blog as BlogModel;

class Blog extends Item
{
    public function toArray(): array
    {
        /** @var BlogModel $blog */
        $blog = $this->collectionItem->item;

        return [
            'type' => 'blog',
            'id' => $blog->id,
            'title' => $blog->title,
            'description' => $blog->meta_description,
            'long_description' => $blog->description,
            'created_at' => $blog->created_at,
            'image' => $blog->main_image,
        ];
    }

    public function render(): string
    {
        return $this->viewFactory->make('modules.collections.items.blog', [
            'blog' => $this->collectionItem->item,
            'description' => $this->collectionItem->description,
        ])->render();
    }
}
