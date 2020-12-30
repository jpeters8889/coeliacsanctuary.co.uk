<?php

declare(strict_types=1);

namespace Coeliac\Modules\Collection\Items;

use Coeliac\Modules\EatingOut\Reviews\Models\Review as ReviewModel;

class Review extends Item
{
    public function toArray(): array
    {
        /** @var ReviewModel $review */
        $review = $this->collectionItem->item;

        return [
            'type' => 'review',
            'id' => $review->id,
            'title' => $review->architect_title,
            'description' => $review->meta_description,
            'long_description' => $review->meta_description,
            'created_at' => $review->created_at,
            'image' => $review->main_image,
        ];
    }

    public function render(): string
    {
        return $this->viewFactory->make('modules.collections.items.review', [
            'review' => $this->collectionItem->item,
            'description' => $this->collectionItem->description,
        ])->render();
    }
}
