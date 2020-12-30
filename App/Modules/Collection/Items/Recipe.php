<?php

declare(strict_types=1);

namespace Coeliac\Modules\Collection\Items;

use Coeliac\Modules\Recipe\Models\Recipe as RecipeModel;

class Recipe extends Item
{
    public function toArray(): array
    {
        /** @var RecipeModel $recipe */
        $recipe = $this->collectionItem->item;

        return [
            'type' => 'recipe',
            'id' => $recipe->id,
            'title' => $recipe->title,
            'description' => $recipe->meta_description,
            'long_description' => $recipe->description,
            'created_at' => $recipe->created_at,
            'image' => $recipe->main_image,
        ];
    }

    public function render(): string
    {
        return $this->viewFactory->make('modules.collections.items.recipe', [
            'recipe' => $this->collectionItem->item,
            'description' => $this->collectionItem->description,
        ])->render();
    }
}
